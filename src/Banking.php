<?php

namespace Goyan\Bs2;

use Goyan\Bs2\Utils\Connection;
use Goyan\Bs2\Utils\Helpers;

class Banking
{
    use Helpers;
    use Connection;

    /**
     * Consulta de Saldo
     * Obtém o saldo da conta
     *
     * @return array
     */
    public static function getSaldo()
    {
        $response = self::get('/pj/apibanking/forintegration/v1/contascorrentes/saldo');

        return $response;
    }

    /**
     * Consulta de Extrato
     * Obtém o extrato da conta
     *
     * @return array
     */
    public static function getExtrato()
    {
        $response = self::get('/pj/apibanking/forintegration/v1/contascorrentes/extrato');

        return $response;
    }

    /**
     * Pagamento de boleto
     * Efetua pagamento de título de cobrança ou arrecadação pelo código de barras ou pela linha digitável
     *
     * @param  string $codigoIdentificacao
     * @return array
     */
    public static function getBoleto($codigoIdentificacao)
    {
        try {
            $response = self::get('/pj/apibanking/forintegration/v1/pagamentos/' . $codigoIdentificacao);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Pagamento de boleto
     * Efetua pagamento de título de cobrança ou arrecadação pelo código de barras ou pela linha digitável
     *
     * @param  array $params
     * @return array
     */
    public static function paymentBoleto($params)
    {
        try {
            self::validatePaymentBoletoData($params);

            $response = self::post('/pj/apibanking/forintegration/v1/pagamentos', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Transferência
     * Efetua TED para qualquer titularidade sem cadastro do favorecido
     *
     * @param  array $params
     * @return array
     */
    public static function paymentTransfer($params)
    {
        try {
            self::validatePaymentTransferData($params);

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
