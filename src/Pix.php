<?php

namespace Goyan\Bs2;

use Goyan\Bs2\Utils\Helpers;
use Goyan\Bs2\Utils\Connection;

class Pix
{
    use Helpers;
    use Connection;

    /**
     * Pagamento - Iniciar pagamento por chave
     *
     * @param  string $key
     * @return array
     */
    public static function paymentByKey($key)
    {
        try {
            self::validatePixKey($key);

            $response = self::post('/pix/direto/forintegration/v1/pagamentos/chave', $key);

            return $response;
        } catch (\Exception $e) {
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
    public static function paymentByManual($key)
    {
        try {
            self::validateManualKey($key);

            $response = self::post('/pix/direto/forintegration/v1/pagamentos/manual', $key);

            return $response;
        } catch (\Exception $e) {
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
    public static function confirmPayment($pagamentoId, $params)
    {
        try {
            self::validateConfirmPaymentData($params);

            $response = self::post('/pix/direto/forintegration/v1/pagamentos/' . $pagamentoId . '/confirmacao', $params);

            return $response;
        } catch (\Exception $e) {
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
    public static function paymentDetailsByPagamentoId($pagamentoId)
    {
        try {
            $response = self::get('/pix/direto/forintegration/v1/pagamentos/' . $pagamentoId);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Cobrança dinâmica - Criar
     *
     * @param  array $params
     * @return array
     */
    public static function dynamicCharge($params)
    {
        try {
            self::validateDynamicChargeData($params);

            $response = self::post('/pix/direto/forintegration/v1/qrcodes/dinamico', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Cobrança - Revisar
     *
     * @param  array $params
     * @return array
     */
    public static function chargeDetails($params)
    {
        try {
            self::validateChargeDetailsData($params);

            $response = self::get('/pix/direto/forintegration/v1/cob', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Cobrança - Consultar por TxId.
     *
     * @param  string $txId
     * @return array
     */
    public static function chargeDetailsByTxId($txId)
    {
        try {
            self::validateChargeDetailsByTxIdData([
                'txId' => $txId
            ]);

            $response = self::get('/pix/direto/forintegration/v1/cob/' . $txId);

            return $response;
        } catch (\Exception $e) {
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
    public static function receiptDetails($params)
    {
        try {
            self::validateReceiptDetailsData($params);

            $response = self::get('/pix/direto/forintegration/v1/recebimentos', $params);

            return $response;
        } catch (\Exception $e) {
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
    public static function receiptDetailsByRecebimentoId($recebimentoId)
    {
        try {
            self::validateReceiptDetailsByRecebimentoIdData([
                'recebimentoId' => $recebimentoId
            ]);

            $response = self::get('/pix/direto/forintegration/v1/recebimentos/' . $recebimentoId);

            return $response;
        } catch (\Exception $e) {
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
    public static function payments($params)
    {
        try {
            $response = self::get('/pix/direto/forintegration/v1/pagamentos', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Webhook - Consultar.
     *
     * @return array
     */
    public static function getWebhookRegistrations()
    {
        try {
            $response = self::get('/pix/direto/forintegration/v1/webhook/bs2');

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Webhook - Configurar.
     *
     * @param  array $params
     * @return array
     */
    public static function updateWebhookRegistrations($params)
    {
        try {
            self::validateUpdateWebhookRegistrationsData($params);

            $response = self::put('/pix/direto/forintegration/v1/webhook/bs2', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Webhook - Excluir.
     *
     * @param  string $inscricaoId
     * @return array
     */
    public static function deleteWebhook($inscricaoId)
    {
        try {
            self::validateDeleteWebhookData([
                'inscricaoId' => $inscricaoId
            ]);

            $response = self::delete('/pix/direto/forintegration/v1/webhook/bs2/' . $inscricaoId);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /**
     * Webhook - Incluir certificado.
     *
     * @param  array $params
     * @return array
     */
    public static function includeWebhookCertificate($params)
    {
        self::validateIncludeWebhookCertificateData($params);

        try {
            $response = self::putAttach('/pix/direto/forintegration/v1/webhook/bs2/certificado', 'certificado', $params['filePath'], $params['newFileName'] ?? $params['filePath']);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }
}
