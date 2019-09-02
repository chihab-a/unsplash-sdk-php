<?php

namespace Chihab\UnsplashSdk\Api\Resources;

use Chihab\UnsplashSdk\Api\Unsplash;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class Photos extends Unsplash
{
    /**
     * Get List photos.
     *
     * @param array $params
     * 
     * @return StdClass
     * @throws GuzzleException
     */
    public function getPhotos(array $params = [])
    {
        return $this->getUnsplashClient()->sendRequest('GET', 'photos', $params);
    }
}
