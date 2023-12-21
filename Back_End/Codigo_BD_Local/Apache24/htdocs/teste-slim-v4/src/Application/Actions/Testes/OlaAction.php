<?php
declare(strict_types=1);

namespace App\Application\Actions\Testes;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;

class OlaAction extends Action
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
        $body->write('EAI PESSUAU');
        return $this->response->withBody($body);
    }
}
