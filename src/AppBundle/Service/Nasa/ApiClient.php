<?php

namespace AppBundle\Service\Nasa;

use AppBundle\Service\Nasa\Client\AbstractClient;
use AppBundle\Service\Nasa\Client\ClientV1;
use AppBundle\Service\Nasa\Repository\AbstractRepository;

class ApiClient
{
    const V1 = 'v1';

    protected $request;

    protected $version;

    private $repositories = [];

    /**
     * Init version based client
     *
     * @param string $url     api url
     * @param string $apiKey  api key
     * @param string $version api version
     *
     */
    public function __construct($url, $apiKey, $version = self::V1)
    {
        $this->version = $version;

        switch ($version) {
            case self::V1:
                $this->request = new ClientV1($url, $apiKey, $version);
                break;
        }
    }

    /**
     * Get API version
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @return AbstractClient
     */
    public function request() : AbstractClient
    {
        return $this->request;
    }

    public function getRepository(string $className)
    {
        $class = __NAMESPACE__.'\\Repository\\'.strtoupper($this->version).'\\'.$className;

        if (!class_exists($class)) {
            throw  new \Exception('Repository class does not exist');
        }

        if (!is_subclass_of($class,  AbstractRepository::class)) {
            throw  new \Exception($class.' should be instance of '.AbstractRepository::class);
        }

        if (array_key_exists($class, $this->repositories)) {
            return $this->repositories[$class];
        }

        $this->repositories[$class] = new $class($this->request);

        return $this->repositories[$class];
    }
}
