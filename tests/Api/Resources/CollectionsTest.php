<?php

namespace Chihab\UnsplashSdk\Api\Tests\Api\Resources;

use Chihab\UnsplashSdk\Api\Resources\Collections;
use Chihab\UnsplashSdk\Api\Tests\Api\UnsplashTest;
use stdClass;

class CollectionsTest extends UnsplashTest
{
    protected $collections;

    protected function setUp(): void
    {
        parent::setUp();
        $this->collections = new Collections();
    }

    public function testGetCollections()
    {
        $this->sendRequestMock();
        $this->collections->setUnsplashClient($this->unsplashClient);

        $this->assertNotNull($this->collections->getCollections());
    }

    private function sendRequestMock()
    {
        $this->unsplashClient->shouldReceive('sendRequest')
            ->with('GET', 'collections', [])
            ->andReturn(new StdClass);
    }
}
