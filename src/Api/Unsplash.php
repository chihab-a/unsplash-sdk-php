<?php

namespace Chihab\UnsplashSdk\Api;

use Chihab\UnsplashSdk\Api\Client\UnsplashClient as UnsplashClient;
use GuzzleHttp\Exception\GuzzleException;

class Unsplash
{
    /**
     * Unsplash Api Client
     *
     * @var UnsplashClient
     */
    private $unsplashClient;
    
    /**
     * Access token for authenticated requests.
     *
     * @var string
     */
    private $accessToken;
    
    /**
     * Api Client id.
     *
     * @var string
     */
    private $clientId;
    
    /**
     * Api Client secret
     *
     * @var string
     */
    private $clientSecret;
    
    /**
     * Authentication callback url.
     *
     * @var string
     */
    private $redirectUrl;
    
    /**
     * Api access scopes.
     *
     * @var string
     */
    private $scopes;
    
    /**
     * Initialize.
     *
     * @param mixed $credentials
     *
     * @return void
     */
    public function __construct($credentials = null)
    {
        if (!is_null($credentials)) {
            $this->setUpCredentials($credentials);
            $this->setBasicApiClient();
        }
    }
    
    /**
     * Connect to the Api using credentials.
     *
     * @param mixed $credentials
     *
     * @return void
     */
    public function connect($credentials)
    {
        $this->setUpCredentials($credentials);
        $this->setBasicApiClient();
    }
    
    /**
     * Get the url to authenticate the user to Unsplash.
     *
     * @return string
     */
    public function getAuthenticationUrl()
    {
        $params = [
            'client_id' => $this->clientId,
            'redirect_uri' => $this->redirectUrl,
            'response_type' => 'code',
            'scope' => $this->scopes,
        ];
        
        return 'https://unsplash.com/oauth/authorize?' . http_build_query($params);
    }

    /**
     * Get the access token (authenticate) from the user
     * to make requests to unsplash's Api using the authorization code.
     *
     * @param string $authorizationCode
     *
     * @return void
     * @throws GuzzleException
     */
    public function authenticate($authorizationCode)
    {
        $token = $this->unsplashClient->requestToken(
            $authorizationCode,
            $this->clientId,
            $this->clientSecret,
            $this->redirectUrl
        );
        
        $this->accessToken = $token->access_token;
        
        $this->unsplashClient->authenticate($this->accessToken);
    }

    /**
     * Get the Api Client instance.
     * 
     * @return UnsplashClient
     */
    public function getUnsplashClient()
    {
        return $this->unsplashClient;
    }

    /**
     * Set the Api Client instance.
     *
     * @param mixed $unsplashClient
     *
     * @return void
     */
    public function setUnsplashClient($unsplashClient)
    {
        $this->unsplashClient = $unsplashClient;
    }
    
    /**
     * Get the Api Client id.
     *
     * @return string
     */
    public function getClientId()
    {
        return $this->clientId;
    }
    
    /**
     * Get the Api Client secret.
     *
     * @return string
     */
    public function getClientSecret()
    {
        return $this->clientSecret;
    }

    /**
     * Get the access token.
     *
     * @return string
     */
    public function getAccessToken()
    {
        return $this->accessToken;
    }

    /**
     * Set the access token.
     *
     * @param string $accessToken
     *
     * @return void
     */
    public function setAccessToken($accessToken)
    {
        $this->accessToken = $accessToken;
        $this->unsplashClient->authenticate($this->accessToken);
    }
    
    /**
     * Setup initial Api credentials.
     *
     * @param mixed $credentials
     *
     * @return void
     */
    private function setUpCredentials($credentials)
    {
        if (is_array($credentials)) {
            // using full credentials
            $this->clientId = $credentials['Client-id'];
            $this->clientSecret = $credentials['Client-secret'];
            $this->redirectUrl = $credentials['redirect-url'];
            $this->scopes = $credentials['scopes'];
        } else {
            // using self issued access token
            $this->accessToken = $credentials;
        }
    }
    
    /**
     * Minimal setup for unsplash's Api Client.
     * Just get it ready to request for access tokens.
     *
     * @return void
     */
    private function setBasicApiClient()
    {
        $this->unsplashClient = new UnsplashClient();
        // if using a self issued access token,
        // just authenticate the user right now
        if (!is_null($this->accessToken)) {
            $this->unsplashClient->authenticate($this->accessToken);
        }
    }
}
