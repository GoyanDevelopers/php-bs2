<?php

namespace Goyan\Bs2;

use GuzzleHttp\Exception\ClientException;
use Exception;

class Request
{
    /**
     * Realiza uma solicitação get
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    public function get($url, $params = null)
    {
        try {
            $request = $this->client->request('GET', $url, [
                'headers' => [
                    'Authorization' => "Bearer " . $this->access_token,
                    'Accept' => 'application/json',
                ],
                'form_params' => $params
            ]);

            $body = $request->getBody();

            return [
                'code' => $request->getStatusCode(),
                'response' => json_decode($body->getContents(), true)
            ];

        } catch (ClientException $e) {
            $response = $e->getResponse();
            throw new Exception($response->getBody(), $e->getCode());
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
    public function post($url, $params = null)
    {
        try {
            $request = $this->client->request('POST', $url, [
                'headers' => [
                    'Authorization' => "Bearer " . $this->access_token
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
            throw new Exception($response->getBody(), $e->getCode());
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
    public function put($url, $params = null)
    {
        try {
            $request = $this->client->request('PUT', $url, [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => "Bearer " . $this->access_token
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
            throw new Exception($response->getBody(), $e->getCode());
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
    public function delete($url, $params = null)
    {
        try {
            $request = $this->client->request("DELETE", $url, [
                'headers' => [
                    'Authorization' => "Bearer " . $this->access_token
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
            throw new Exception($response->getBody(), $e->getCode());
        }
    }
}
