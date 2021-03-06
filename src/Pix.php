<?php

namespace Goyan\Bs2;

use Goyan\Bs2\Request;
use Exception;

class Pix extends Request
{

    public static function init($api_key, $api_secret, $access_token = false)
    {
        $static = new static($api_key, $api_secret, $access_token);

        $static->PixCredentials();

        return $static;
    }

    /**
     * Pagamento - Iniciar pagamento por chave
     *
     * @param  string $key
     * @return array
     */
    public function paymentByKey($key)
    {
        try {
            $response = $this->post('/pix/direto/forintegration/v1/pagamentos/chave', $key);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Pagamento - Iniciar pagamento por chave
     *
     * @param  string $key
     * @return array
     */
    public function paymentByManual($key)
    {
        try {
            $response = $this->post('/pix/direto/forintegration/v1/pagamentos/manual', $key);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }


    /**
     * Pagamento - Confirmar
     *
     * @param  string $pagamentoId
     * @param  array $params
     * @return array
     */
    public function confirmPayment($pagamentoId, $params)
    {
        try {
            $response = $this->post('/pix/direto/forintegration/v1/pagamentos/' . $pagamentoId . '/confirmacao', $params);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Pagamento - Consultar por PagamentoId
     *
     * @param  string $pagamentoId
     * @return array
     */
    public function paymentDetailsByPagamentoId($pagamentoId)
    {
        try {
            $response = $this->get('/pix/direto/forintegration/v1/pagamentos/' . $pagamentoId);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Cobran??a din??mica - Criar
     *
     * @param  array $params
     * @return array
     */
    public function dynamicCharge($params)
    {
        try {
            $response = $this->post('/pix/direto/forintegration/v1/qrcodes/dinamico', $params);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Cobran??a - Revisar
     *
     * @param  array $params
     * @return array
     */
    public function chargeDetails($params)
    {
        try {
            $response = $this->get('/pix/direto/forintegration/v1/cob', $params);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Cobran??a - Consultar por TxId.
     *
     * @param  string $txId
     * @return array
     */
    public function chargeDetailsByTxId($txId)
    {
        try {
            $response = $this->get('/pix/direto/forintegration/v1/cob/' . $txId);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Recebimento - Consultar
     *
     * @param  string $params
     * @return array
     */
    public function receiptDetails($params)
    {
        try {
            $response = $this->get('/pix/direto/forintegration/v1/recebimentos', $params);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Recebimento - Consultar por RecebimentoId
     *
     * @param  string $recebimentoId
     * @return array
     */
    public function receiptDetailsByRecebimentoId($recebimentoId)
    {
        try {
            $response = $this->get('/pix/direto/forintegration/v1/recebimentos/' . $recebimentoId);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Pagamentos - Consultar.
     *
     * @param  array $params
     * @return array
     */
    public function payments($params)
    {
        try {
            $response = $this->get('/pix/direto/forintegration/v1/pagamentos', $params);

            return $response;
        } catch (Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }
}
