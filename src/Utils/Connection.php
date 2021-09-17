<?php

namespace Goyan\Bs2\Utils;

use Illuminate\Support\Facades\Http;
use Goyan\Bs2\Models\Token;

trait Connection
{
    public static function getToken()
    {
        $token = Token::firstOrFail();

        if (!$token->status) {
            throw new \Exception('Sistema indisponível no momento, retorne novamente em alguns minutos');
        }

        return $token;
    }

    public static function refleshConnection($refresh_token)
    {
        $token = Token::firstOrCreate();

        $token->update(['status' => 0]);

        $params = [
            'grant_type' => 'refresh_token',
            'scope' => config('bs2.scope'),
            'refresh_token' => $refresh_token
        ];

        $response = self::auth($params);

        if ($response['code'] == 200) {

            if ($response['response']['access_token']) {
                $token->update(array_merge($response['response'], ['status' => 1]));

                return $response['response'];
            }
        }

        throw new \Exception('O Token "' . $refresh_token . '" não foi aceito pela BS2, realize um novo disparo');
    }


    /*
     * Realiza uma solicitação post utilizando Basic Authentication
     * para gerar um token de acesso.
     *
     * @param array $params
     * @return array
     */
    public static function auth($params)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json',
                'Content-Type' => 'application/x-www-form-urlencoded'
            ])
                ->asForm()
                ->withBasicAuth(config('bs2.api_key'), config('bs2.api_secret'))
                ->post(config('bs2.server') . '/auth/oauth/v2/token', $params);

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
    public static function get($url, $params = null)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->withToken(self::getToken()->access_token)
                ->get(config('bs2.server') . $url, $params);

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
    public static function post($url, $params = null)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->withToken(self::getToken()->access_token)
                ->post(config('bs2.server') . $url, $params);

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
    public static function put($url, $params = null)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->withToken(self::getToken()->access_token)
                ->put(config('bs2.server') . $url, $params);

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
    public static function delete($url, $params = null)
    {
        try {
            $response = Http::withHeaders([
                'Accept' => 'application/json'
            ])
                ->withToken(self::getToken()->access_token)
                ->delete(config('bs2.server') . $url, $params);

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
    public static function putAttach($url, $fileName, $filePath, $newFileName)
    {
        try {
            $response = Http::attach($fileName, file_get_contents($filePath), $newFileName)
                ->withToken(self::getToken()->access_token)
                ->put(config('bs2.server') . $url);

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
