<?php
declare(strict_types=1);

namespace App\Application\Actions\Gymlog;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class exerciseGetAction extends Action
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

        $STH = $this->link->prepare("SELECT * FROM exercise;");
        if($STH->execute()){
            $records = $STH->fetchAll();
            $res["err"] = 0;
            $res['exercises']=$records;
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json',);
        }
        else{
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, Erro ao obter exercicios";
            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }

    }
}
?>