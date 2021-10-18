<?php

namespace Goyan\Bs2;

use Goyan\Bs2\Request;
use Exception;

class Banking extends Request
{
    public $client;
    public $access_token;

    public function __construct($setup, $access_token = false)
    {
        $this->client = $setup->client;
        $this->access_token = $access_token ?? $setup->access_token;
    }

    /**
     * Consulta de Saldo
     * Obtém o saldo da conta
     *
     * @return array
     */
    public function getSaldo()
    {
        $response = $this->get('/pj/apibanking/forintegration/v1/contascorrentes/saldo');

        return $response;
    }

    /**
     * Consulta de Extrato
     * Obtém o extrato da conta
     *
     * @return array
     */
    public function getExtrato()
    {
        $response = $this->get('/pj/apibanking/forintegration/v1/contascorrentes/extrato');

        return $response;
    }

    /**
     * Pagamento de boleto
     * Efetua pagamento de título de cobrança ou arrecadação pelo código de barras ou pela linha digitável
     *
     * @param  string $codigoIdentificacao
     * @return array
     */
    public function getBoleto($codigoIdentificacao)
    {
        try {
            $response = $this->get('/pj/apibanking/forintegration/v1/pagamentos/' . $codigoIdentificacao);

            return $response;
        } catch (Exception $e) {
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
    public function paymentBoleto($params)
    {
        try {
            $response = $this->post('/pj/apibanking/forintegration/v1/pagamentos', $params);

            return $response;
        } catch (Exception $e) {
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
    public function paymentTransfer($params)
    {
        try {
            $response = $this->post('/pj/apibanking/forintegration/v1/transferencias/simplificado', $params);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }
}
