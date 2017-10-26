<?php

namespace AppBundle\Service\Nasa\Methods\V1;

trait Feed
{
    public function feed($params)
    {
        $res = $this->client->get($this->makeUrl('/feed'), [
            'query' => $params
        ]);

        return $this->getResponse($res);
    }

}
