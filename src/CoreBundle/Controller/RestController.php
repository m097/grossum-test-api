<?php

namespace CoreBundle\Controller;

use Doctrine\ODM\MongoDB\Cursor;
use FOS\RestBundle\Context\Context;
use FOS\RestBundle\Controller\FOSRestController;


abstract class RestController extends FOSRestController
{
    protected function createApiResponse($data, array $groups = [], $status = 200)
    {
        $restContext = (new Context())
            ->setSerializeNull(true);
        if ($groups) {
            $restContext->setGroups($groups);
        }

        $view = $this->view($data, $status)
             ->setFormat('json')
             ->setContext($restContext);

        return $this->handleView($view);
    }

    protected function prepareRepositoryItems(Cursor $items)
    {
        return array_values($items->toArray());
    }
}
