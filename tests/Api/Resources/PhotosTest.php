<?php

namespace Chihab\UnsplashSdk\Api\Tests\Api\Resources;

use Chihab\UnsplashSdk\Api\Resources\Photos;
use Chihab\UnsplashSdk\Api\Tests\Api\UnsplashTest;
use stdClass;

class PhotosTest extends UnsplashTest
{
    protected $photos;

    protected function setUp(): void
    {
        parent::setUp();
        $this->photos = new Photos();
    }

    public function testGetPhotos()
    {
        $this->sendRequestMock();
        $this->photos->setUnsplashClient($this->unsplashClient);

        $this->assertNotNull($this->photos->getPhotos());
    }

    private function sendRequestMock()
    {
        $this->unsplashClient->shouldReceive('sendRequest')
            ->with('GET', 'photos', [])
            ->andReturn(new StdClass);
    }
}
