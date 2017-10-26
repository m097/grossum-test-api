<?php

namespace AppBundle\Service\Nasa\Client;

use AppBundle\Service\Nasa\Methods\V1\Feed;

class ClientV1 extends AbstractClient
{
    use Feed;
}
