<?php

namespace Goyan\Bs2;

abstract class Setup
{
    protected $Client;

    protected $Endpoint;

    protected $ApiKey;

    protected $ApiSecret;

    protected $Scope;

    protected $RefreshToken;

    protected $AccessToken;

    /**
     * Get the value of Client
     */
    public function Client()
    {
        return $this->Client;
    }

    /**
     * Set the value of Client
     *
     * @return  self
     */
    public function setClient($Client)
    {
        $this->Client = $Client;

        return $this;
    }

    /**
     * Get the value of AccessToken
     */
    public function getAccessToken()
    {
        return $this->AccessToken;
    }

    /**
     * Set the value of AccessToken
     *
     * @return  self
     */
    public function setAccessToken($AccessToken)
    {
        $this->AccessToken = $AccessToken;

        return $this;
    }

    /**
     * Get the value of Endpoint
     */
    public function getEndpoint()
    {
        return $this->Endpoint ?? 'https://api.bs2.com';
    }

    /**
     * Set the value of Endpoint
     *
     * @return  self
     */
    public function setEndpoint($Endpoint)
    {
        $this->Endpoint = $Endpoint;

        return $this;
    }

    /**
     * Get the value of ApiKey
     */
    public function getApiKey()
    {
        return $this->ApiKey;
    }

    /**
     * Set the value of ApiKey
     *
     * @return  self
     */
    public function setApiKey($ApiKey)
    {
        $this->ApiKey = $ApiKey;

        return $this;
    }

    /**
     * Get the value of ApiSecret
     */
    public function getApiSecret()
    {
        return $this->ApiSecret;
    }

    /**
     * Set the value of ApiSecret
     *
     * @return  self
     */
    public function setApiSecret($ApiSecret)
    {
        $this->ApiSecret = $ApiSecret;

        return $this;
    }

    /**
     * Get the value of Scope
     */
    public function getScope()
    {
        return $this->Scope ?? 'saldo extrato pagamento boleto cob.write cob.read pix.write pix.read dict.write dict.read webhook.read webhook.write cobv.write cobv.read';
    }

    /**
     * Get the value of RefreshToken
     */
    public function getRefreshToken()
    {
        return $this->RefreshToken;
    }

    /**
     * Set the value of RefreshToken
     *
     * @return  self
     */
    public function setRefreshToken($RefreshToken)
    {
        $this->RefreshToken = $RefreshToken;

        return $this;
    }
}
