<?php

namespace Goyan\Bs2\Utils;

use Illuminate\Support\Facades\Http;
use Goyan\Bs2\Models\Token;

trait Connection
{
    /**
     * Buscar token de acesso
     *
     * @return mixed
     */
    public static function getToken()
    {
        $token = Token::firstOrFail();

        if (!$token->status) {
            throw new \Exception('Sistema indisponível no momento, retorne novamente em alguns minutos');
        }

        return $token;
    }

    /**
     * Atualizar token de acesso
     *
     * @param  mixed $refresh_token
     * @return void
     */
    public static function refleshConnection($refresh_token)
    {
        try {

            $token = Token::firstOrCreate();

            $token->update(['status' => 0]);

            $params = [
                'grant_type' => 'refresh_token',
                'scope' => config('bs2.scope'),
                'refresh_token' => $refresh_token
            ];

            $response = Http::timeout(30)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])
                ->asForm()
                ->withBasicAuth(config('bs2.api_key'), config('bs2.api_secret'))
                ->post(config('bs2.server') . '/auth/oauth/v2/token', $params);

            if ($response->getStatusCode() == 200) {

                $responseJson = $response->json();

                if (isset($responseJson['refresh_token'])) {
                    $token->update(array_merge(['status' => 1], $responseJson));

                    return $responseJson;
                }
            }

            throw new \Exception('O Token "' . $refresh_token . '" não foi aceito pela BS2, confira o arquivo config/bs2.php e em seguida realize um novo disparo');
        } catch (\Throwable $th) {
            throw $th;
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

    /**
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

    /**
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

    /**
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

    /**
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
