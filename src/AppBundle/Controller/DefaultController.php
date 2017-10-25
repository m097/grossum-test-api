<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends RestController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->createApiResponse(['hello' => 'world!']);
    }
}
