<?php
declare(strict_types=1);

namespace App\Application\Actions\Gymlog;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class getExerciseUserAction extends Action
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
        $pid = $_GET['pid'];
        $STH = $this->link->prepare("SELECT * FROM exercise e, plan_exercise pe, plan p 
                                    WHERE e.e_id=pe.e_id AND pe.p_id=p.p_id AND pe.p_id=? AND p.u_id=?;");
        if($STH->execute(array($pid,$uid))){
            $records = $STH->fetchAll();
            $res["err"] = 0;
            $res["plan_exercises"] = $records;
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json',);
        }
        else{
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, Erro ao obter os exercicios associados ao plano do utilizador";
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }
    }

}

?>