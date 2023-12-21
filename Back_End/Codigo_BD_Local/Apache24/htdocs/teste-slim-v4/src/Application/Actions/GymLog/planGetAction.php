<?php
declare(strict_types=1);

namespace App\Application\Actions\Gymlog;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class planGetAction extends Action
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
        $uid = $this->request->getAttribute("uid");
        $STH = $this->link->prepare("SELECT * FROM plan where u_id=?;");
        if($STH->execute(array($uid))){
            $records = $STH->fetchAll();
            $res["err"] = 0;
            $res['plans']=$records;
            
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json',);
        }
        else{
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, Erro ao obter planos do utilizador";
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }

    }
}
?>