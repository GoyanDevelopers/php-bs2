<?php

namespace Goyan\Bs2;

use Goyan\Bs2\Utils\Connection;
use Goyan\Bs2\Utils\Helpers;

class Banking
{
    use Helpers;

    protected $http;

    /*
     * Cria uma nova instância de BankingConnection.
     *
     * @return void
     */
    public function __construct()
    {
        $this->http = new Connection();

        if ($this->http->token->status !== 1) {
            return ['code' => 400];
        }
    }

    /*
     * Consulta o saldo do cliente Bs2.
     *
     * @return array
     */
    public function getSaldo()
    {
        $saldo = $this->http->get('/pj/apibanking/forintegration/v1/contascorrentes/saldo');

        return $saldo;
    }

    public function getBoleto($codigoIdentificacao)
    {
        try {

            $response = $this->http->get('/pj/apibanking/forintegration/v1/pagamentos/' . $codigoIdentificacao);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    public function paymentBoleto($params)
    {
        try {
            $this->validatePaymentBoletoData($params);

            $response = $this->http->post('/pj/apibanking/forintegration/v1/pagamentos', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    public function paymentTed($params)
    {
        try {
            $this->validatePaymentTedData($params);

            $response = $this->http->post('/pj/apibanking/forintegration/v1/transferencias/simplificado', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }
}
