<?php

namespace Goyan\Bs2\Utils;

use Illuminate\Support\Facades\Http;
use Goyan\Bs2\Models\Token;
use Exception;
trait Connection
{
    /**
     * Buscar token de acesso
     *
     * @return mixed
     */
    public static function getToken()
    {
        $token = Token::first();

        if (!$token->status) {
            throw new Exception('Sistema indisponível no momento, retorne novamente em alguns minutos');
        }

        return $token;
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
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
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }
}
