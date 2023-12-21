<?php

declare(strict_types=1);

namespace App\Application\Actions\Users;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

use \PDO;

class LoginAction extends Action
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
        $input = json_decode($json, true); // assume-se que dados são recebidos via JSON

        $sth = $this->link->prepare("SELECT * FROM users WHERE U_USERNAME = ? AND U_PASSWORD = ?");
        $sth->bindParam(1, $input['username']);
        $sth->bindParam(2, $input['password']);
        $sth->execute();
    
        $usr = $sth->fetchAll();
    
        $res = array();


        if(count($usr)>0){
            $res["token"] = md5((string) time());
            $res["user_name"] = $usr[0]["U_USERNAME"];
            $res["user_id"] = $usr[0]["U_ID"];

            //update do token e da validade to token
            $sth = $this->link->prepare("UPDATE users SET U_AUTH_TOKEN = ? WHERE U_ID = ?");
            $sth->bindParam(1, $res["token"]);
            $sth->bindParam(2, $res["user_id"]);
            $sth->execute();
        } else{
            $res["auth"] = "KO" . $input['username'] . " " . $input['password'];
        }

        $payload = json_encode($res);
        $this->response->getBody()->write($payload);
        return $this->response->withHeader('Content-Type', 'application/json');
    }
}
