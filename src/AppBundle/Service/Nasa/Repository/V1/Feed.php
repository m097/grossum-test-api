<?php

namespace AppBundle\Service\Nasa\Repository\V1;

use AppBundle\Service\Nasa\Client\ClientV1;
use AppBundle\Service\Nasa\Repository\AbstractRepository;

class Feed extends AbstractRepository
{
    /**
     * @return ClientV1
     */
    protected function request() : ClientV1
    {
        return $this->getClient();
    }

    public function getLastFeed(int $days = 3)
    {
        $format = 'Y-m-d';
        $now = new \DateTime('now');

        return $this->request()->feed([
           'start_date' => (new \DateTime('now'))->sub(new \DateInterval('P'.$days.'D'))->format($format),
           'end_date' => (new \DateTime('now'))->format($format),
           'detailed' => false,
       ]);
    }
}
