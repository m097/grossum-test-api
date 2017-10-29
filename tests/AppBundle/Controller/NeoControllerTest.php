<?php

namespace AppBundle\Controller;

use AppBundle\Document\NearEarthObject;
use CoreBundle\Test\ApiTestCase;
use Symfony\Component\HttpFoundation\Response;

class NeoControllerTest extends ApiTestCase
{
    public function testGetHazardousAction()
    {
        $this->createTestNeo();

        $client = $this->getClient();
        $client->request('GET', '/neo/hazardous');
        $body = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->asserter()->assertResponsePropertyExists($client->getResponse(), 'hazardous_neos');
        $this->assertCount(1, $body['hazardous_neos']);
        $this->asserter()->assertResponsePropertyExists($client->getResponse(), 'hazardous_neos[0].name');
    }

    public function testGetFastestAction()
    {
        $this->createTestNeo();

        $client = $this->getClient();
        $client->request('GET', '/neo/fastest');
        $body = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->asserter()->assertResponsePropertyExists($client->getResponse(), 'fastest_neos');
        $this->assertCount(0, $body['fastest_neos']);


        $client->request('GET', '/neo/fastest?hazardous=true');
        $body = json_decode($client->getResponse()->getContent(), true);

        $this->assertEquals($client->getResponse()->getStatusCode(), Response::HTTP_OK);
        $this->asserter()->assertResponsePropertyExists($client->getResponse(), 'fastest_neos');
        $this->assertCount(1, $body['fastest_neos']);
        $this->asserter()->assertResponsePropertyExists($client->getResponse(), 'fastest_neos[0].name');
    }

    private function createTestNeo()
    {
        $neo = (new NearEarthObject())
            ->setName('test')
            ->setIsHazardous(true)
            ->setSpeed(10000)
            ->setReference(123468)
            ->setDate(new \DateTime('now'));

        $this->getDocumentManager()->persist($neo);
        $this->getDocumentManager()->flush();
    }
}
