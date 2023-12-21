<?php
declare(strict_types=1);

namespace App\Application\Actions\Gymlog;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class increaseSeriesExeAction extends Action
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
        $uid = $this->request->getAttribute("uid");
        $data = json_decode($json, true);
        $STH = $this->link->prepare("SELECT COUNT(*) AS 'count' FROM plan WHERE u_id=? AND p_id=?");
        $STH->execute(array($uid,$data['pid']));
        $contagem = $STH->fetchAll();
        if($contagem[0]['count']==0){
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, plano nao pertence ao utilizador";
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }
        else{
            $STH = $this->link->prepare("UPDATE plan_exercise SET pe_done=pe_done+1 WHERE p_id=? AND e_id=?;");
        if($STH->execute(array($data['pid'],$data['eid']))){
            $res["err"] = 0;
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json',);
        }
        else{
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, Erro ao atualizar o numero de series do exercicio";
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }
        }
        
    }

}

?>