<?php

namespace Goyan\Bs2;

use Goyan\Bs2\Utils\Connection;
use Goyan\Bs2\Utils\Helpers;

class Banking
{
    use Helpers;
    use Connection;

    /*
     * Consulta o saldo do cliente Bs2.
     *
     * @return array
     */
    public static function getSaldo()
    {
        return self::get('/pj/apibanking/forintegration/v1/contascorrentes/saldo');
    }

    public static function getBoleto($codigoIdentificacao)
    {
        try {
            return self::get('/pj/apibanking/forintegration/v1/pagamentos/' . $codigoIdentificacao);
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    public static function paymentBoleto($params)
    {
        try {
            self::validatePaymentBoletoData($params);

            return self::post('/pj/apibanking/forintegration/v1/pagamentos', $params);
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    public static function paymentTed($params)
    {
        try {
            self::validatePaymentTedData($params);

            $response = self::post('/pj/apibanking/forintegration/v1/transferencias/simplificado', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }
}
