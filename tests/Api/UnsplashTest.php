<?php

namespace Chihab\UnsplashSdk\Api\Tests\Api;

use Chihab\UnsplashSdk\Api\Unsplash;
use PHPUnit\Framework\TestCase;
use Mockery;
use StdClass;

class UnsplashTest extends TestCase
{
    protected $unsplash;
    protected $unsplashClient;
    protected $authorizationCode = '1234567890';
    protected $credentials = [
        'Client-id' => 'CLIENT-ID',
        'Client-secret' => 'CLIENT-SECRET',
        'redirect-url' => 'http://url.com/callback',
        'scopes' => 'scope1,scope2',
    ];
    
    protected function setUp(): void
    {
        $this->unsplash = new Unsplash();
        $this->unsplashClient = Mockery::mock('Chihab\UnsplashSdk\Api\Client\UnsplashClient');
    }
    
    public function testConnectToApiInConstructor()
    {
        $unsplash = new Unsplash($this->credentials);
        $this->assertEquals('CLIENT-ID', $unsplash->getClientId());
        $this->assertEquals('CLIENT-SECRET', $unsplash->getClientSecret());
    }
    
    public function testConnectToApiWithConnectMethod()
    {
        $unsplash = new Unsplash();
        $unsplash->connect($this->credentials);
        $this->assertEquals('CLIENT-ID', $unsplash->getClientId());
        $this->assertEquals('CLIENT-SECRET', $unsplash->getClientSecret());
    }
    
    public function testConnectToApiInConstructorUsingSelfIssuedAccessToken()
    {
        $unsplash = new Unsplash('SELF-ISSUED-ACCESS-TOKEN');
        $this->assertNotNull($unsplash->getAccessToken());
        $this->assertEquals('SELF-ISSUED-ACCESS-TOKEN', $unsplash->getAccessToken());
    }
    
    public function testConnectToApiWithConnectMethodUsingSelfIssuedAccessToken()
    {
        $this->unsplash->connect('SELF-ISSUED-ACCESS-TOKEN');
        $this->assertNotNull($this->unsplash->getAccessToken());
        $this->assertEquals('SELF-ISSUED-ACCESS-TOKEN', $this->unsplash->getAccessToken());
    }
    
    public function testGetAuthenticationUrl()
    {
        $this->unsplash->connect($this->credentials);
        $expectedUrl = 'https://unsplash.com/oauth/authorize?client_id=CLIENT-ID&' .
            'redirect_uri=http%3A%2F%2Furl.com%2Fcallback&' .
            'response_type=code&scope=scope1%2Cscope2' ;
        $authenticationUrl = $this->unsplash->getAuthenticationUrl();
        $this->assertEquals($expectedUrl, $authenticationUrl);
    }
    
    public function testAuthenticate()
    {
        $this->authenticationMocks();
        
        $this->unsplash->connect($this->credentials);
        $this->unsplash->setUnsplashClient($this->unsplashClient);
        $this->unsplash->authenticate($this->authorizationCode);
        
        $this->assertEquals('ACCESS-TOKEN', $this->unsplash->getAccessToken());
    }
   
    protected function authenticationMocks()
    {
        $tokens = new StdClass();
        $tokens->access_token = 'ACCESS-TOKEN';
        
        $this->unsplashClient->shouldReceive('requestToken')
            ->with('1234567890', 'CLIENT-ID', 'CLIENT-SECRET', 'http://url.com/callback')
            ->once()
            ->andReturn($tokens);
        
        $this->unsplashClient->shouldReceive('authenticate')
            ->with('ACCESS-TOKEN')
            ->once()
            ->andReturnNull();
    }
}
