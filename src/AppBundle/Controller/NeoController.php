<?php

namespace AppBundle\Controller;

use CoreBundle\Controller\RestController;
use FOS\RestBundle\Controller\Annotations\Get;
use Symfony\Component\HttpFoundation\Request;

class NeoController extends RestController
{
    /**
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
     * @Get("/neo/fastest", name="neo:fastest")
     */
    public function getFastestAction(Request $request)
    {
        $neoRepo = $this->get('doctrine_mongodb')->getRepository('AppBundle:NearEarthObject');
        $items = array_values($neoRepo->getFastest($request)->toArray());

        return $this->createApiResponse(['fastest_neos' => $items]);
    }
}
