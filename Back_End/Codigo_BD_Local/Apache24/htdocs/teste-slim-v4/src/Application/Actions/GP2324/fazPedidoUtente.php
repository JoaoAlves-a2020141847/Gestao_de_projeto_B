<?php
declare(strict_types=1);

namespace App\Application\Actions\GP2324;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class fazPedidoUtente extends Action
{
    private PDO $link;

    public function __construct(LoggerInterface $logger, PDO $link)
    {
        parent::__construct($logger);
        $this->link = $link;
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $json = $this->request->getBody()->getContents();
        $body = $this->response->getBody();
        $data = json_decode($json, true); // dados recebidos via JSON
        $peid = $this->request->getAttribute("peid");

        $this->response->getBody()->write(json_encode($peid));
        return $this->response->withHeader('Content-Type', 'application/json');
        $STH = $this->link->prepare("SELECT COUNT(*) AS 'count'  FROM exercise WHERE e_id=?");
        $STH->execute(array($data["eid"]));
        $contagem = $STH->fetchAll();
        if($contagem[0]['count']==0){
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, exercicio nao existe";
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }
        else{
            $STH = $this->link->prepare("SELECT COUNT(*) AS 'count' FROM plan WHERE u_id=? AND p_id=?");
            $STH->execute(array($uid,$data["pid"]));
            $contagem = $STH->fetchAll();
            if($contagem[0]['count']==0){
                $res["err"] = 1;
                $res["err_txt"] = "Insucesso, plano nao pertence ao utilizador";
                $this->response->getBody()->write(json_encode($res));
                return $this->response->withHeader('Content-Type', 'application/json');
            }
            else{
                $STH = $this->link->prepare("INSERT INTO plan_exercise (p_id,e_id,pe_series,pe_done) values (?,?,?,0);");
                if($STH->execute(array($data["pid"],$data["eid"],$data["series"]))){
                    $res["err"] = 0;
                    $this->response->getBody()->write(json_encode($res));
                    return $this->response->withHeader('Content-Type', 'application/json',);
                }
                else{
                    $res["err"] = 1;
                    $res["err_txt"] = "Insucesso, Erro ao adicionar exercicio ao plano do utilizador";
                    $this->response->getBody()->write(json_encode($res));
                    return $this->response->withHeader('Content-Type', 'application/json');
                }
            }
        }
    }
}
?>