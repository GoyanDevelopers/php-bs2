<?php

namespace Goyan\Bs2;

use Goyan\Bs2\Utils\Helpers;
use Goyan\Bs2\Utils\Connection;

class Pix
{
    use Helpers;

    protected $http;

    /*
     * Cria uma nova instância de PixConnection.
     *
     * @return void
     */
    public function __construct()
    {
        $this->http = new Connection();

        if ($this->http->token->status == 0) {
            return ['code' => 401];
        }
    }

    /*
     * Pagamento - Iniciar pagamento por chave.
     *
     * @param array $key
     * @return array
     */
    public function startPaymentByKey($key)
    {
        try {
            $this->validatePixKey($key);

            $response = $this->http->post('/pix/direto/forintegration/v1/pagamentos/chave', $key);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Pagamento - Confirmar
     *
     * @param int $pagamentoId
     * @param int $value
     * @return array
     */
    public function confirmPayment($pagamentoId, $params)
    {
        try {
            $this->validateConfirmPaymentData($params);

            $response = $this->http->post('/pix/direto/forintegration/v1/pagamentos/' . $pagamentoId . '/confirmacao', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Pagamento - Consultar por PagamentoId.
     *
     * @param int $pagamentoId
     * @return array
     */
    public function paymentDetailsByPagamentoId($pagamentoId)
    {
        try {
            $response = $this->http->get('/pix/direto/forintegration/v1/pagamentos/' . $pagamentoId);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Cobrança dinâmica - Criar.
     *
     * @param array $params
     * @return array
     */
    public function dynamicCharge($params)
    {
        try {
            $this->validateDynamicChargeData($params);

            $response = $this->http->post('/pix/direto/forintegration/v1/qrcodes/dinamico', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Cobrança - Consultar.
     *
     * @param array $params
     * @return array
     */
    public function chargeDetails($params)
    {
        try {
            $this->validateChargeDetailsData($params);

            $response = $this->http->get('/pix/direto/forintegration/v1/cob', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Cobrança - Consultar por TxId.
     *
     * @param int $txId
     * @return array
     */
    public function chargeDetailsByTxId($txId)
    {
        try {
            $this->validateChargeDetailsByTxIdData([
                'txId' => $txId
            ]);

            $response = $this->http->get('/pix/direto/forintegration/v1/cob/' . $txId);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Recebimento - Consultar.
     *
     * @param array $params
     * @return array
     */
    public function receiptDetails($params)
    {
        try {
            $this->validateReceiptDetailsData($params);

            $response = $this->http->get('/pix/direto/forintegration/v1/recebimentos', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Recebimento - Consultar por RecebimentoId.
     *
     * @param int $recebimentoId
     * @return array
     */
    public function receiptDetailsByRecebimentoId($recebimentoId)
    {
        try {
            $this->validateReceiptDetailsByRecebimentoIdData([
                'recebimentoId' => $recebimentoId
            ]);

            $response = $this->http->get('/pix/direto/forintegration/v1/recebimentos/' . $recebimentoId);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Pagamentos - Consultar.
     *
     * @return array
     */
    public function payments($params)
    {
        try {
            $response = $this->http->get('/pix/direto/forintegration/v1/pagamentos', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Webhook - Consultar.
     *
     * @return array
     */
    public function getWebhookRegistrations()
    {
        try {
            $response = $this->http->get('/pix/direto/forintegration/v1/webhook/bs2');

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Webhook - Configurar.
     *
     * @param array $params
     * @return array
     */
    public function updateWebhookRegistrations($params)
    {
        try {
            $this->validateUpdateWebhookRegistrationsData($params);

            $response = $this->http->put('/pix/direto/forintegration/v1/webhook/bs2', $params);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Webhook - Excluir.
     *
     * @param string $inscricaoId
     * @return array
     */
    public function deleteWebhookRegistration($inscricaoId)
    {
        try {
            $this->validateDeleteWebhookRegistrationData([
                'inscricaoId' => $inscricaoId
            ]);

            $response = $this->http->delete('/pix/direto/forintegration/v1/webhook/bs2/' . $inscricaoId);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }

    /*
     * Webhook - Incluir certificado.
     *
     * @param array $params
     * @return array
     */
    public function includeWebhookCertificate($params)
    {
        $this->validateIncludeWebhookCertificateData($params);

        try {
            $response = $this->http->putAttach('/pix/direto/forintegration/v1/webhook/bs2/certificado', 'certificado', $params['filePath'], $params['newFileName'] ?? $params['filePath']);

            return $response;
        } catch (\Exception $e) {
            return [
                'code' => $e->getCode(),
                'response' => $e->getMessage()
            ];
        }
    }
}
