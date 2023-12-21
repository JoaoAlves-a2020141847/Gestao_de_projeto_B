<?php

declare(strict_types=1);

namespace App\Application\Actions\Testes;

use App\Application\Actions\Action;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Log\LoggerInterface;
use \PDO;

class ListCarsAction extends Action
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
        $db = $this->link;
        $sth = $db->prepare("SELECT * FROM carros");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        $this->logger->info("Lista de carros.");
        $payload = json_encode($data);
        $this->response->getBody()->write($payload);
        return $this->response->withHeader('Content-Type', 'application/json');
        //return $this->respondWithData($data);
    }
}