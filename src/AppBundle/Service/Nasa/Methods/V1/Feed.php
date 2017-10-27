<?php

namespace AppBundle\Service\Nasa\Methods\V1;

use AppBundle\Service\Nasa\Response\ApiResponse;

trait Feed
{
    /**
     * @param array $params
     *
     * @return ApiResponse
     */
    public function feed(array $params) : ApiResponse
    {
        $res = $this->client->get($this->makeUrl('/feed'), [
            'query' => $params
        ]);

        return $this->getResponse($res);
    }

}
