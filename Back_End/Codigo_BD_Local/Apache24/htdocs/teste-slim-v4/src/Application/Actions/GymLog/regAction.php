<?php
declare(strict_types=1);

namespace App\Application\Actions\Gymlog;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class regAction extends Action
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
        $this->response->getBody()->write(json_encode($data));
        return $this->response->withHeader('Content-Type', 'application/json');

        
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $STH = $this->link->prepare("SELECT * From user where u_username=?;");
        $STH->execute(array($data['username']));
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $records = $STH->fetch();
        if(!empty($records)){
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, username ja existente";

            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }
        else{
            $STH = $this->link->prepare("INSERT INTO user (u_name,u_username,u_pass,u_photo,u_token) values (?,?,?,?,?);");
            if($STH->execute(array($data['name'],$data['username'],$data['password'],$data['photo'],''))){
                $res["err"] = 0;
                $this->response->getBody()->write(json_encode($res));
                return $this->response->withHeader('Content-Type', 'application/json');
            }
            else{
                $res["err"] = 1;
                $res["err_txt"] = "Insucesso, erro ao inserir os dados na base de dados";
                $this->response->getBody()->write(json_encode($res));
                return $this->response->withHeader('Content-Type', 'application/json');
            }
        }

    }

}

?>