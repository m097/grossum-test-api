<?php

namespace AppBundle\Controller;

use CoreBundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class DefaultControllerTest extends ApiTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertEquals($client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->asserter()->assertResponsePropertyEquals($client->getResponse(), 'hello', 'world!');
    }
}
