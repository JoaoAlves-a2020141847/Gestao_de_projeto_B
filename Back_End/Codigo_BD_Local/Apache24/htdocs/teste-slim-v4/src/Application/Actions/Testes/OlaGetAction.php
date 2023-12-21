<?php
declare(strict_types=1);

namespace App\Application\Actions\Testes;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class OlaGetAction extends Action
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
        $body = $this->response->getBody();
        $name = $this->args['name']; // acesso ao parâmetro passado via GET
        $body->write('hello ' . $name . '!');
        return $this->response->withBody($body);
    }
}


/*

        // ID utilizador vindo do Middleware
        $user_id = $this->request->getAttribute('uid');
        $name = $this->args['name']; // acesso ao parâmetro passado via GET
        $body->write('hello ' . $name . $user_id . '!');
        return $this->response->withBody($body);
*/
