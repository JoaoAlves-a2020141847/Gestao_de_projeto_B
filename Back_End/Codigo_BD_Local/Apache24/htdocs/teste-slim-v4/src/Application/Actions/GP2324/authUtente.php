<?php
declare(strict_types=1);

namespace App\Application\Actions\GP2324;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class authUtente extends Action
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
        $STH = $this->link->prepare("SELECT p.pe_id, pe_senha From pessoa p, utente u where p.pe_id=u.pe_id and u_numcc=?;");
        $STH->execute(array($data['cc']));
        
        $records = $STH->fetch();
        if(!empty($records)){
            if(password_verify( $data['password'] , $records["pe_senha"])){
                unset($records["pe_senha"]);
                
                $token=md5((string)time()).md5((string)$data['cc']);

                $STH = $this->link->prepare("UPDATE pessoa
                                            SET 
                                                pe_token 	= 	?
                                            WHERE pe_id = ?;");
                if($STH->execute(array($token,$records["pe_id"]))){
                    $records["pe_token"] = $token;
                    $res["cc"] = array();
                    array_push($res["cc"],$records);
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