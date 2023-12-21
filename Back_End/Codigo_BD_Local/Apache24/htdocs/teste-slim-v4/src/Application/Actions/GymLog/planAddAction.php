<?php
declare(strict_types=1);

namespace App\Application\Actions\Gymlog;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class planAddAction extends Action
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
        $data = json_decode($json, true); // dados recebidos via JSON
        $uid = $this->request->getAttribute("uid");
        $STH = $this->link->prepare("INSERT INTO plan (u_id,p_name,p_date) values (?,?,?);");
        if($STH->execute(array($uid,$data["name"],$data["date"]))){
            $res["err"] = 0;
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json',);
        }
        else{
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, Erro inserir o plano";
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }

    }
}
?>