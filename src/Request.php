<?php

namespace Goyan\Bs2;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;
use Goyan\Bs2\Setup;
use Exception;

abstract class Request extends Setup
{

    protected function __construct($api_key, $api_secret, $access_token = false)
    {
        $this->setApiKey($api_key);
        $this->setApiSecret($api_secret);
        $this->setAccessToken($access_token);

        $this->setClient(
            new Client([
                'base_uri' => $this->getEndpoint(),
                'headers' => [
                    'Accept'     => 'application/json'
                ]
            ])
        );

        return $this;
    }

    protected function PixCredentials()
    {
        if ($this->getAccessToken() == false) {

            try {
                $request = $this->Client()->request('POST', '/auth/oauth/v2/token', [
                    'auth' => [
                        $this->getApiKey(), $this->getApiSecret()
                    ],
                    'form_params' => [
                        'grant_type' => 'client_credentials',
                        'scope' => 'pix.write pix.read'
                    ]
                ]);

                $body = $request->getBody();

                $json = json_decode($body->getContents(), true);

                $this->setAccessToken($json['access_token']);
            } catch (Exception | ClientException $e) {
                throw $e;
            }
        }
    }

    protected function BankingCredentials()
    {
        if ($this->getAccessToken() == false) {

            try {
                $request = $this->Client()->request('POST', '/auth/oauth/v2/token', [
                    'auth' => [
                        $this->getApiKey(), $this->getApiSecret()
                    ],
                    'form_params' => [
                        "grant_type" => "refresh_token",
                        'scope' => 'pagamento boleto',
                        "refresh_token" => $this->getRefreshToken()
                    ]
                ]);

                $body = $request->getBody();

                $json = json_decode($body->getContents(), true);

                $this->setRefreshToken($json['refresh_token']);

                $this->setAccessToken($json['access_token']);
            } catch (Exception | ClientException $e) {
                throw $e;
            }
        }
    }

    /**
     * Realiza uma solicitação get
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    protected function get($url)
    {
        try {
            $request = $this->Client()->request('GET', $url, [
                'headers' => [
                    'Authorization' => "Bearer " . $this->getAccessToken(),
                    'Accept' => 'application/json',
                ]
            ]);

            $body = $request->getBody();

            return [
                'code' => $request->getStatusCode(),
                'response' => json_decode($body->getContents(), true)
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();

            return [
                'code' => $e->getCode(),
                'response' => json_decode($response->getBody()->getContents(), true)
            ];
        }
    }

    /**
     * Realiza uma solicitação post padrão utilizando
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    protected function post($url, $params = null)
    {
        try {
            $request = $this->Client()->request('POST', $url, [
                'headers' => [
                    'Authorization' => "Bearer " . $this->getAccessToken()
                ],
                'json' => $params
            ]);

            $body = $request->getBody();

            return [
                'code' => $request->getStatusCode(),
                'response' => json_decode($body->getContents(), true)
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();

            return [
                'code' => $e->getCode(),
                'response' => json_decode($response->getBody()->getContents(), true)
            ];
        }
    }

    /**
     * Realiza uma solicitação put padrão utilizando
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    protected function put($url, $params = null)
    {
        try {
            $request = $this->Client()->request('PUT', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer " . $this->getAccessToken()
                ],
                'json' => $params
            ]);

            $body = $request->getBody();

            return [
                'code' => $request->getStatusCode(),
                'response' => json_decode($body->getContents(), true)
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();

            return [
                'code' => $e->getCode(),
                'response' => json_decode($response->getBody()->getContents(), true)
            ];
        }
    }

    /**
     * Realiza uma solicitação delete padrão utilizando
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    protected function delete($url, $params = null)
    {
        try {
            $request = $this->Client()->request("DELETE", $url, [
                'headers' => [
                    'Authorization' => "Bearer " . $this->getAccessToken()
                ],
                'json' => $params
            ]);

            $body = $request->getBody();

            return [
                'code' => $request->getStatusCode(),
                'response' => json_decode($body->getContents(), true)
            ];
        } catch (ClientException $e) {
            $response = $e->getResponse();

            return [
                'code' => $e->getCode(),
                'response' => json_decode($response->getBody()->getContents(), true)
            ];
        }
    }
}
