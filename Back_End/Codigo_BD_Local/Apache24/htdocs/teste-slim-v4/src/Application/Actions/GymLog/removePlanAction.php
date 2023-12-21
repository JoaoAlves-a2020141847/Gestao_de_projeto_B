<?php
declare(strict_types=1);

namespace App\Application\Actions\Gymlog;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class removePlanAction extends Action
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
        $uid = $this->request->getAttribute("uid");
        $STH = $this->link->prepare("DELETE FROM plan WHERE p_id=? AND u_id=?;");
        if($STH->execute(array($data["pid"],$uid))){
            $STH = $this->link->prepare("DELETE FROM plan_exercise WHERE p_id=? ;");
            if($STH->execute(array($data["pid"]))){
                $res["err"] = 0;
                $this->response->getBody()->write(json_encode($res));
                return $this->response->withHeader('Content-Type', 'application/json',);
            }
            else{
                $res["err"] = 1;
                $res["err_txt"] = "Insucesso, Erro ao remover associacao de plano e exercicio";
                $this->response->getBody()->write(json_encode($res));
                return $this->response->withHeader('Content-Type', 'application/json');
            }
        }
        else{
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, Erro ao remover o plano do utilizador";
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }
    }

}

?>