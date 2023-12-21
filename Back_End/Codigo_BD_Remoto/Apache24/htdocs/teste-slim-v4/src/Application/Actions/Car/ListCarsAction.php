<?php

declare(strict_types=1);

namespace App\Application\Actions\Car;

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
        $sth = $db->prepare("SELECT * FROM rooms");
        $sth->execute();
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        $this->logger->info("Users list was viewed.");

        return $this->respondWithData($data);
    }
}
