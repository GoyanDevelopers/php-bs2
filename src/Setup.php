<?php

namespace Goyan\Bs2;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Exception;

class Setup
{
    public $api_key;
    public $api_secret;
    public $client;
    public $access_token;

    public function __construct($endpoint, $api_key, $api_secret)
    {
        $this->api_key = $api_key;
        $this->api_secret = $api_secret;

        $this->client = new Client([
            'base_uri' => $endpoint,
            'headers' => [
                'Accept'     => 'application/json'
            ]
        ]);
    }

    /**
     * Buscar token de acesso
     *
     * @return mixed
     */
    public function GenerateAccessToken($refresh_token, $scope)
    {
        try {
            $request = $this->client->request('POST', '/auth/oauth/v2/token', [
                'auth' => [
                    $this->api_key, $this->api_secret
                ],
                'headers' => [
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ],
                'timeout'  => 30,
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'scope' => $scope,
                    'refresh_token' => $refresh_token
                ]
            ]);

            $body = $request->getBody();

            $json = json_decode($body->getContents(), true);

            $this->access_token = $json['access_token'];

            return $json;
        } catch (ClientException $e) {
            throw new Exception($e->getResponse()->getBody(), $e->getCode());
        } catch (Exception $e) {
            throw $e;
        }
    }
}
