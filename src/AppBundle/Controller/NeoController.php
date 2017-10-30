<?php

namespace AppBundle\Controller;

use CoreBundle\Controller\RestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;
use FOS\RestBundle\Controller\Annotations\QueryParam;

class NeoController extends RestController
{
    /**
     * @ApiDoc(
     *  section="Neos",
     *  resource=false,
     *  description="Hazardous NEOs"
     * )
     * @QueryParam(name="page", requirements="\d+", default="1", description="Current page")
     * @QueryParam(name="per_page", requirements="\d+", default="10", description="Items per page")
     * @Get("/neo/hazardous", name="neo:hazardous")
     */
    public function getHazardousAction(Request $request)
    {
        $neoRepo = $this->get('doctrine_mongodb')->getRepository('AppBundle:NearEarthObject');
        $itemsQb = $neoRepo->getHazardousQueryBuilder();
        $collection = $this->get('pagination_factory')->createCollection($itemsQb, $request);
        $collection->setItemsKey('hazardous_neos');

        return $this->createApiResponse($collection);
    }

    /**
     * @ApiDoc(
     *  section="Neos",
     *  resource=false,
     *  description="Fastest NEOs"
     * )
     * @QueryParam(name="count", requirements="\d+", default="5", description="Items count")
     * @QueryParam(name="hazardous", requirements="true|false", default="false", description="Is hazardous")
     * @Get("/neo/fastest", name="neo:fastest")
     */
    public function getFastestAction(Request $request)
    {
        $neoRepo = $this->get('doctrine_mongodb')->getRepository('AppBundle:NearEarthObject');
        $items = $this->prepareRepositoryItems($neoRepo->getFastest($request));

        return $this->createApiResponse(['fastest_neos' => $items]);
    }
}
