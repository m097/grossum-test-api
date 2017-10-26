<?php

namespace AppBundle\Service\Nasa\Client;

use AppBundle\Service\Nasa\Response\ApiResponse;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Handler\StreamHandler;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Uri;
use Psr\Http\Message\RequestInterface;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;


abstract class AbstractClient
{
    protected $client;

    protected $version;

    public function __construct($url, $apiKey, $version)
    {
        if (empty($version) || $version !== 'v1') {
            throw new \InvalidArgumentException(
                'Version parameter must be not empty and must be equal v1'
            );
        }

        $this->version = $version;

        $stack = new HandlerStack();
        $stack->setHandler(new StreamHandler());
        $stack->unshift(Middleware::mapRequest(function (RequestInterface $request) use ($apiKey) {
            return $request->withUri(Uri::withQueryValue($request->getUri(), 'api_key', $apiKey));
        }));

        $this->client = new GuzzleClient([
         'base_uri' => $url,
         'query' => ['api_key' => $apiKey],
         'handler' => $stack
        ]);
    }


    protected function makeUrl($url)
    {
        return '/neo/rest/'.$this->version.$url;
    }

    protected function getResponse(Response $res)
    {
        return new ApiResponse($res->getStatusCode(), $res->getBody());
    }

}
