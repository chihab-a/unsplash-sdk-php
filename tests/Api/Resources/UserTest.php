<?php

namespace Chihab\UnsplashSdk\Api\Tests\Api\Resources;

use Chihab\UnsplashSdk\Api\Resources\User;
use Chihab\UnsplashSdk\Api\Tests\Api\UnsplashTest;
use stdClass;

class UserTest extends UnsplashTest
{
    protected $user;
    
    protected function setUp(): void 
    {
        parent::setUp();
        $this->user = new User();
    }

    public function testGetAuthenticatedUser() {
        
        $this->sendRequestMock();
        $this->user->setUnsplashClient($this->unsplashClient);
        
        $this->assertNotNull($this->user->getAuthenticatedUser());
    }
    
    private function sendRequestMock()
    {
        $this->unsplashClient->shouldReceive('sendRequest')
            ->with('GET', 'me')
            ->andReturn(new StdClass);
    }
}
