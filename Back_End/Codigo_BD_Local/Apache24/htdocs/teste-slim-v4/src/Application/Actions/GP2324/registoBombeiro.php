<?php
declare(strict_types=1);

namespace App\Application\Actions\GP2324;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class registoBombeiro extends Action
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
        $STH = $this->link->prepare("SELECT * From pessoa p , bombeiro b 
                                    where p.pe_id=b.pe_id 
                                    and pe_email=? or pe_contacto=? or b_user=? ;");
        $STH->execute(array($data['email'],$data['contacto'],$data['user']));
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
                
                $STH = $this->link->prepare("INSERT INTO bombeiro (pe_id,b_funcao,b_posicao,b_admin,b_estado,b_user) 
                                        values (?,?,?,?,?,?);");
                if($STH->execute(array($pessoaId,$data['funcao'],$data['posicao'],
                    $data['admin'],$data['estado'],$data['user']))){
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