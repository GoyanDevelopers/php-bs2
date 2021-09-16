<?php

namespace Goyan\Bs2\Utils;

use Illuminate\Support\Facades\Http;
use Goyan\Bs2\Models\Token;
use Goyan\Bs2\Jobs\RenewToken;

class Connection
{
    public $token;
    public $new_token = false;

    public function __construct()
    {
        $this->token = Token::first();
    }

    public function refreshTokenAcess()
    {

        $this->token->update(['status' => 0]);

        $params = [
            'grant_type' => 'refresh_token',
            'scope' => $this->token->scope,
            'refresh_token' => $this->token->refresh_token
        ];

        $response = $this->auth($params);

        if ($response['code'] == 200) {

            if ($response['response']['access_token']) {

                $this->token->update(array_merge($response['response'], ['status' => 1]));

                $this->new_token = $response['response']['refresh_token'];
                return;
            }
        }

        throw new \Exception('Falha ao renovar o token de acesso');
    }


    /*
     * Realiza uma solicitação post utilizando Basic Authentication
     * para gerar um token de acesso.
     *
     * @param array $params
     * @return array
     */
    public function auth($params)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])
                ->asForm()
                ->withBasicAuth($this->token->api_key, $this->token->api_secret)
                ->post($this->token->base_url . '/auth/oauth/v2/token', $params);

            return [
                'code' => $response->getStatusCode(),
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Realiza uma solicitação get padrão utilizando
     * Bearer Authentication.
     *
     * @param string $url
     * @param array|null $params
     * @return array
     */
    public function get($url, $params = null)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->withToken($this->token->access_token)
                ->get($this->token->base_url . $url, $params);

            return [
                'code' => $response->getStatusCode(),
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
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
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->withToken($this->token->access_token)
                ->post($this->token->base_url . $url, $params);

            return [
                'code' => $response->getStatusCode(),
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
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
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->withToken($this->token->access_token)
                ->put($this->token->base_url . $url, $params);

            return [
                'code' => $response->getStatusCode(),
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
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
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->withToken($this->token->access_token)
                ->delete($this->token->base_url . $url, $params);

            return [
                'code' => $response->getStatusCode(),
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Realiza uma solicitação put com envio de arquivos
     * utilizando Bearer Authentication.
     *
     * @param string $url
     * @param string $fileName
     * @param string $filePath
     * @param string $newFileName
     * @return array
     */
    public function putAttach($url, $fileName, $filePath, $newFileName)
    {
        try {
            $response = Http::attach($fileName, file_get_contents($filePath), $newFileName)
                ->withToken($this->token->access_token)
                ->put($this->token->base_url . $url);

            return [
                'code' => $response->getStatusCode(),
                'response' => $response->json()
            ];
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }
}
