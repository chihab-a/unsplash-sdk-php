<?php

namespace Chihab\UnsplashSdk\Api\Resources;

use Chihab\UnsplashSdk\Api\Unsplash;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class User extends Unsplash
{

    /**
     * Get the current authenticated user object.
     *
     * @return StdClass
     * @throws GuzzleException
     */
    public function getAuthenticatedUser()
    {
        return $this->getUnsplashClient()->sendRequest('GET', 'me');
    }
}
