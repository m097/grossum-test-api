<?php

namespace CoreBundle\Service\Pagination;

use Doctrine\ODM\MongoDB\Query\Builder;
use Pagerfanta\Adapter\DoctrineODMMongoDBAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Component\HttpFoundation\Request;

class PaginationFactory
{
    public function createCollection(Builder $cursor, Request $request) : PaginatedCollection
    {
        $page = $request->query->get('page', 1);
        $perPage = $request->query->get('per_page', 10);

        $adapter = new DoctrineODMMongoDBAdapter($cursor);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage($perPage);
        $pagerfanta->setCurrentPage($page);

        $items = [];
        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $items[] = $result;
        }

        return new PaginatedCollection($items, $pagerfanta->getNbResults());
    }
}
