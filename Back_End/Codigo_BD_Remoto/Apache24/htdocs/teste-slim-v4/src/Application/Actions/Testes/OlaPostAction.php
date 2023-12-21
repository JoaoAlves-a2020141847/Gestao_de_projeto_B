<?php

declare(strict_types=1);

namespace App\Application\Actions\Testes;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class OlaPostAction extends Action
{
    public function __construct(LoggerInterface $logger)
    {
        parent::__construct($logger);
    }

    /**
     * {@inheritdoc}
     */
    protected function action(): Response
    {
        $json = $this->request->getBody()->getContents();
        $data = json_decode($json, true); // dados recebidos via JSON
        $name = $data['name'];
        $res = array("res" => strtoupper('hello ' . $name . '!'));
        $this->logger->info("Teste com post processado");
        $this->response->getBody()->write(json_encode($res));
        return $this->response->withHeader('Content-Type', 'application/json');
    }
}

        /*

        // ID utilizador vindo do Middleware
        $user_id = $this->request->getAttribute('uid');

        $res = array("res" => strtoupper('hello ' . $name . $user_id . '!'));

        $body = $this->response->getBody();

        $name = $this->args['name']; // acesso ao parâmetro passado via GET

        $body->write('Hello ' . $name . '!');
        return $this->response->withBody($body);
        */