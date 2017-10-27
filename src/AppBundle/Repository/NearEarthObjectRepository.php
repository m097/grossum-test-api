<?php

namespace AppBundle\Repository;

use AppBundle\Document\NearEarthObject;
use AppBundle\Tool\Helper\ObjectHelper;
use Doctrine\ODM\MongoDB\DocumentRepository;

class NearEarthObjectRepository extends DocumentRepository
{
    public function persistFromApi(array $feed)
    {
        $dm = $this->getDocumentManager();
        $objectHelper = ObjectHelper::create();
        $proceed = 0;

        $dbFeed = $this->getByReferenceIds($this->getAllIdsFromApiResponse($feed));

        foreach ($feed as $date => $items) {
            foreach ($items as $item) {
                $neo = NearEarthObject::fromArray($item);
                if (array_key_exists($neo->getReference(), $dbFeed)) {
                    $objectHelper->merge($dbFeed[$neo->getReference()], $neo);
                } else {
                    $dm->persist($neo);
                }
                $proceed++;
            }
        }

        $dm->flush();

        return $proceed;
    }

    private function getAllIdsFromApiResponse($feed)
    {
        $ids = [];
        foreach ($feed as $date => $items) {
            foreach ($items as $item) {
                if (array_key_exists('neo_reference_id', $item)) {
                    $ids[] = (int)$item['neo_reference_id'];
                }
            }
        }

        return $ids;
    }

    public function getByReferenceIds($ids)
    {
        $feedRes = $this->createQueryBuilder()
            ->field('reference')->in($ids)
            ->sort('id', 'ASC')
            ->getQuery()
            ->execute();

        $feed = [];
        /** @var NearEarthObject  $item */
        foreach ($feedRes as $item) {
            if ($item->getReference()) {
                $feed[$item->getReference()] = $item;
            }
        }

        return $feed;
    }

    public function clearAll()
    {
        $dm = $this->getDocumentManager();
        $nasa = $dm->getRepository('AppBundle:NearEarthObject')
            ->findAll();
        foreach ($nasa as $feed) {
            $dm->remove($feed);
        }
        $dm->flush();
    }
}
