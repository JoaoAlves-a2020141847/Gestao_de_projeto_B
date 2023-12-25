<?php
declare(strict_types=1);

namespace App\Application\Actions\GP2324;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class registoUtente extends Action
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
        $data = json_decode($json, true);
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $STH = $this->link->prepare("SELECT * From pessoa p , utente u
                                    where p.pe_id=u.pe_id 
                                    and pe_email=? or pe_contacto=? or u_numcc=? ;");
        $STH->execute(array($data['email'],$data['contacto'],$data['cc']));
        $STH->setFetchMode(PDO::FETCH_OBJ);
        $records = $STH->fetch();
        if(!empty($records)){
            $res["err"] = 1;
            $res["err_txt"] = "Insucesso, username ou email ja existente";

            $this->response->getBody()->write(json_encode($res));
            return $this->response->withHeader('Content-Type', 'application/json');
        }
        else{
            $STH = $this->link->prepare("INSERT INTO pessoa (pe_nome,pe_email,pe_senha,pe_contacto,pe_morada,pe_codigopostal) 
                                        values (?,?,?,?,?,?);");
            if($STH->execute(array($data['name'],$data['email'],$data['password'],
                $data['contacto'],$data['morada'],$data['codigopostal']))){
                $pessoaId = $this->link->lastInsertId();
                
                $STH = $this->link->prepare("INSERT INTO utente (pe_id,u_numcc,u_datavalidade,u_estado) 
                                        values (?,?,?,?);");
                if($STH->execute(array($pessoaId,$data['cc'],$data['validade'],
                    $data['estado']))){
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