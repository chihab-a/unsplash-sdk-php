<?php

namespace Chihab\UnsplashSdk\Api\Client;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;
use stdClass;

class UnsplashClient
{
    /**
     * Unsplash authorization url
     *
     * @var string
     */
    private $authorizationUrl = 'https://unsplash.com/oauth/authorize';

    /**
     * Unsplash access token url
     *
     * @var string
     */
    private $accessTokenUrl = 'https://unsplash.com/oauth/token';

    /**
     * Unsplash Api url
     *
     * @var string
     */
    private $apiUrl = 'https://Api.unsplash.com/';

    /**
     * Guzzle http Client
     *
     * @var GuzzleClient
     */
    private $client;

    /**
     * Ask Unsplash for the access and refresh token
     * using the provided authorization code.
     *
     * @param string $clientId
     * @param string $clientSecret
     * @param string $redirectUrl
     * @param string $authorizationCode
     *
     * @return StdClass
     * @throws GuzzleException
     */
    public function requestToken($clientId, $clientSecret, $redirectUrl, $authorizationCode)
    {
        $data = [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'redirect_uri' => $redirectUrl,
                'code' => $authorizationCode,
                'grant_type' => 'authorization_code',
            ],
        ];

        $client = new GuzzleClient([
            'base_uri' => $this->accessTokenUrl,
            'exceptions' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Accept-Charset' => 'utf-8',
            ],
        ]);

        $response = $client->request('POST', 'tokens', $data);

        return json_decode((string) $response->getBody());
    }

    /**
     * Authenticate Client to make authenticated requests.
     *
     * @param string $accessToken
     *
     * @return void
     */
    public function authenticate($accessToken)
    {
        $this->client = new GuzzleClient([
            'base_uri' => $this->apiUrl,
            'exceptions' => false,
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Accept-Charset' => 'utf-8',
                'Authorization' => 'Bearer ' . $accessToken,
            ],
        ]);
    }

    /**
     * Send a request to Unsplash's Api.
     *
     * @param string $method
     * @param string $endpoint
     * @param array $data
     *
     * @return StdClass
     * @throws GuzzleException
     */
    public function sendRequest($method, $endpoint, array $data = [])
    {
        $response = $this->client->request($method, $endpoint, $data);
        return json_decode((string) $response->getBody());
    }
}
