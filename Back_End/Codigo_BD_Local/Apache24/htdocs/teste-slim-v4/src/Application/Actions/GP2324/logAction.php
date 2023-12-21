<?php
declare(strict_types=1);

namespace App\Application\Actions\Gymlog;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class logAction extends Action
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
        $STH = $this->link->prepare("SELECT u_username, u_name, u_photo , u_pass From user where u_username=?;");
        $STH->execute(array($data['username']));
        
        $records = $STH->fetch();
        if(!empty($records)){
            if(password_verify( $data['password'] , $records["u_pass"])){
                unset($records["u_pass"]);
                
                $token=md5((string)time()).md5((string)$data['username']);

                $STH = $this->link->prepare("UPDATE user
                                            SET 
                                                u_token 	= 	?
                                            WHERE u_username = ?;");
                if($STH->execute(array($token,$data['username']))){
                    $records["u_token"] = $token;
                    $res["user"] = array();
                    array_push($res["user"],$records);
                    $res["err"] = 0;
                    $this->response->getBody()->write(json_encode($res));
                    return $this->response->withHeader('Content-Type', 'application/json'); 
                }
                else{
                    $res["err"] = 1;
                    $res["err_txt"] = "Insucesso, erro ao definir o token";
                    $this->response->getBody()->write(json_encode($res));
                    return $this->response->withHeader('Content-Type', 'application/json');
                } 
            }
            else{
                $res["err"] = 1;
                $res["err_txt"] = "Insucesso, login mal sucedido";
                $this->response->getBody()->write(json_encode($res));
                return $this->response->withHeader('Content-Type', 'application/json');
            }
        }
        $res["err"] = 1;
        $res["err_txt"] = "Insucesso, utilizador inexistente";
        $this->response->getBody()->write(json_encode($res));
        return $this->response->withHeader('Content-Type', 'application/json');
       
    }

}

?>