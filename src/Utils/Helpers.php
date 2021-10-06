<?php

namespace Goyan\Bs2\Utils;

use Illuminate\Support\Facades\Validator;

trait Helpers
{
    /**
     * Valida chave pix.
     *
     * @param array $key
     * @return void
     */
    public static function validatePixKey($key)
    {
        $validator = Validator::make($key, [
            'chave.id' => 'nullable|string',
            'chave.apelido' => 'nullable|string',
            'chave.valor' => 'required|string',
            'chave.tipo' => 'required|string'

        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados pix.
     *
     * @param array $key
     * @return void
     */
    public static function validateManualKey($key)
    {
        $validator = Validator::make($key, [
            'recebedor.ispb' => 'required|exists:Bancos,ispb',
            'recebedor.conta.agencia' => 'required|string',
            'recebedor.conta.numero' => 'required|string',
            'recebedor.conta.tipo' => 'required|in:ContaCorrente,Poupanca,ContaSalario,ContaPagamento',
            'recebedor.pessoa.documento' => 'required|string',
            'recebedor.pessoa.tipoDocumento' => 'required|in:CPF,CNPJ',
            'recebedor.pessoa.nome' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para confirmação de pagamento.
     *
     * @param array $data
     * @return void
     */
    public static function validateConfirmPaymentData($data)
    {
        $validator = Validator::make($data, [
            'recebedor.ispb' => 'required|string',

            'recebedor.conta.bancoNome' => 'required|string',
            'recebedor.conta.agencia' => 'required|string',
            'recebedor.conta.numero' => 'required|string',
            'recebedor.conta.tipo' => 'required|string',

            'recebedor.pessoa.documento' => 'required|string',
            'recebedor.pessoa.tipoDocumento' => 'required|string',
            'recebedor.pessoa.nome' => 'required|string',
            'recebedor.pessoa.nomeFantasia' => 'nullable|string',

            'valor' => 'required',
            'campoLivre' => 'nullable'

        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }


    /**
     * Valida dados para pagamento de boleto.
     *
     * @param array $data
     * @return void
     */
    public static function validatePaymentBoletoData($data)
    {
        $validator = Validator::make($data, [
            'codigoIdentificacao' => 'required|string',
            'valor' => 'required',
            'efetuarEm' => 'required|date',
            'vencimentoEm' => 'required|date',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para pagamento de TED.
     *
     * @param array $data
     * @return void
     */
    public static function validatePaymentTransferData($data)
    {
        $validator = Validator::make($data, [
            'favorecido.nome' => 'required|string|max:60',
            'favorecido.documento' => 'required|string',

            'favorecido.contaDestino.agencia' => 'required|string',
            'favorecido.contaDestino.numero' => 'required|string',
            'favorecido.contaDestino.banco.codigo' => 'required',
            'favorecido.contaDestino.banco.nome' => 'required|string',
            'favorecido.contaDestino.tipoConta' => 'required',

            'mesmaTitularidade' => 'required|boolean',
            'valor' => 'required',
            'efetuarEm' => 'required',

        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para criação de cobrança dinâmica.
     *
     * @param array $data
     * @return void
     */
    public static function validateDynamicChargeData($data)
    {
        $validator = Validator::make($data, [
            'txId' => 'required|string',
            'cobranca.calendario.expiracao' => 'required|integer',
            'cobranca.devedor.cpf' => 'nullable|string',
            'cobranca.devedor.cnpj' => 'nullable|string',
            'cobranca.devedor.nome' => 'required|string',
            'cobranca.valor.original' => 'required',
            'cobranca.chave' => 'required|string',
            'cobranca.infoAdicionais.nome' => 'nullable|string',
            'cobranca.infoAdicionais.valor' => 'nullable|string',
            'aceitaMaisDeUmPagamento' => 'nullable|boolean',
            'recebivelAposVencimento' => 'nullable|boolean'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para consulta de cobranças.
     *
     * @param array $data
     * @return void
     */
    public static function validateChargeDetailsData($data)
    {
        $validator = Validator::make($data, [
            'Inicio' => 'required|date_format:Y-m-d',
            'Fim' => 'required|date_format:Y-m-d',
            'Cpf' => 'nullable|string',
            'Cnpj' => 'nullable|string',
            'LocationPresent' => 'nullable|boolean',
            'Status' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para consulta de cobrança por txId.
     *
     * @param array $data
     * @return void
     */
    public static function validateChargeDetailsByTxIdData($data)
    {
        $validator = Validator::make($data, [
            'txId' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para consulta de recebimentos.
     *
     * @param array $data
     * @return void
     */
    public static function validateReceiptDetailsData($data)
    {
        $validator = Validator::make($data, [
            'Inicio' => 'required|date_format:Y-m-d',
            'Fim' => 'required|date_format:Y-m-d',
            'Status' => 'nullable|string',
            'txId' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para consulta de recebimentos por recebimentoId.
     *
     * @param array $data
     * @return void
     */
    public static function validateReceiptDetailsByRecebimentoIdData($data)
    {
        $validator = Validator::make($data, [
            'recebimentoId' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para atualização de inscrições do webhook.
     *
     * @param array $data
     * @return void
     */
    public static function validateDeleteWebhookData($data)
    {
        if (!is_array($data)) {
            throw new \Exception("Parameters must be inside an array.");
        }

        $data = $data[0];

        $validator = Validator::make($data, [
            'url' => 'required|string',
            'eventos' => 'required|array',
            'somenteComTxId' => 'required|boolean',
            'contaNumero' => 'required|integer',
            'autorizacao' => 'required|array',
            'autorizacao.valor' => 'required|string',
            'autorizacao.tipo' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para exclusão de inscrição do webhook.
     *
     * @param array $data
     * @return void
     */
    public static function validateDeleteWebhookRegistrationData($data)
    {
        $validator = Validator::make($data, [
            'inscricaoId' => 'required|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }

    /**
     * Valida dados para inclusão de certificado de webhook.
     *
     * @param array $data
     * @return void
     */
    public static function validateIncludeWebhookCertificateData($data)
    {
        $validator = Validator::make($data, [
            'filePath' => 'required|string',
            'newFileName' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            throw new \Exception($validator->errors()->first());
        }
    }
}
