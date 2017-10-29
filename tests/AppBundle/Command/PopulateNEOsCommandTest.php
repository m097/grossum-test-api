<?php

namespace AppBundle\Command;

use CoreBundle\Test\CommandTestCase;

class PopulateNEOsCommandTest extends CommandTestCase
{
    public function testPopulateNEOs()
    {
        $client = static::createClient();
        $output = $this->runCommand($client, "app:populate:neos --clear");

        $this->assertContains('Proceed NEOs', $output);
        $proceed = 0;
        if (preg_match('/Proceed NEOs: (\d+)/m', $output, $matches)) {
            $proceed = $matches[1];
        }
        $this->assertGreaterThan(0, $proceed);

        $dm = $client->getContainer()->get('doctrine.odm.mongodb.document_manager');
        $neos = $dm->getRepository('AppBundle:NearEarthObject')->findAll();
        $this->assertGreaterThan(0, count($neos));
    }
}
