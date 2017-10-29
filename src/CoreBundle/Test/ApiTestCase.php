<?php

namespace CoreBundle\Test;

use Doctrine\Common\DataFixtures\Purger\MongoDBPurger;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\BrowserKit\Client;
use Symfony\Component\Console\Helper\FormatterHelper;
use Symfony\Component\Console\Output\ConsoleOutput;

/**
 * Class ApiTestCase
 * @package CoreBundle\Test
 * @inheritdoc
 */
abstract class ApiTestCase extends WebTestCase
{
    /**
     * @var ConsoleOutput
     */
    private $output;

    /**
     * @var FormatterHelper
     */
    private $formatterHelper;

    private $responseAsserter;

    private $client;

    private static $staticClient;

    public static function setUpBeforeClass()
    {
        self::$staticClient = static::createClient();

        self::bootKernel();
    }

    protected function setUp()
    {
        $this->client = self::$staticClient;

        $purger = new MongoDBPurger($this->getDocumentManager());
        $purger->purge();
    }

    /**
     * Clean up Kernel usage in this test.
     */
    protected function tearDown()
    {
        // purposefully not calling parent class, which shuts down the kernel
    }


    protected function getService($id)
    {
        return static::$kernel->getContainer()->get($id);
    }

    protected function getClient() : Client
    {
        return $this->client;
    }

    /**
     * Print a message out - useful for debugging
     *
     * @param $string
     */
    protected function printDebug($string)
    {
        if ($this->output === null) {
            $this->output = new ConsoleOutput();
        }

        $this->output->writeln($string);
    }

    /**
     * Print a debugging message out in a big red block
     *
     * @param $string
     */
    protected function printErrorBlock($string)
    {
        if ($this->formatterHelper === null) {
            $this->formatterHelper = new FormatterHelper();
        }
        $output = $this->formatterHelper->formatBlock($string, 'bg=red;fg=white', true);

        $this->printDebug($output);
    }

    /**
     * @return ResponseAsserter
     */
    protected function asserter()
    {
        if ($this->responseAsserter === null) {
            $this->responseAsserter = new ResponseAsserter();
        }

        return $this->responseAsserter;
    }

    /**
     * @return DocumentManager
     */
    protected function getDocumentManager()
    {
        return $this->getService('doctrine.odm.mongodb.document_manager');
    }

}
