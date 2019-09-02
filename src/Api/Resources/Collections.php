<?php

namespace Chihab\UnsplashSdk\Api\Resources;

use Chihab\UnsplashSdk\Api\Unsplash;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class Collections extends Unsplash
{
    /**
     * Get List collections.
     *
     * @param array $params
     *
     * @return StdClass
     * @throws GuzzleException
     */
    public function getCollections(array $params = [])
    {
        return $this->getUnsplashClient()->sendRequest('GET', 'collections', $params);
    }
}
