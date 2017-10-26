<?php

namespace AppBundle\Service\Nasa\Repository;

use AppBundle\Service\Nasa\Client\AbstractClient;

abstract class AbstractRepository
{
    private $client;

    public function __construct(AbstractClient $request)
    {
        $this->client = $request;
    }

    public function getClient()
    {
        return $this->client;
    }

    abstract protected function request();
}
