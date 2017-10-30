<?php

namespace AppBundle\Controller;

use CoreBundle\Controller\RestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class DefaultController extends RestController
{
    /**
     * @ApiDoc(
     *  section="Index",
     *  resource=false,
     *  description="Index page"
     * )
     * @Get("/", name="homepage")
     */
    public function indexAction()
    {
        return $this->createApiResponse(['hello' => 'world!']);
    }
}
