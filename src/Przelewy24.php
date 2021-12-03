<?php

namespace Przelewy24;

use Przelewy24\Api\Api;
use Przelewy24\Api\Response\RegisterTransactionResponse;
use Przelewy24\Api\Response\VerifyTransactionResponse;

class Przelewy24
{
    /**
     * @var \Przelewy24\Config
     */
    private $config;

    /**
     * @var \Przelewy24\Api\Api
     */
    private $api;

    /**
     * @param array $parameters
     */
    public function __construct(array $parameters)
    {
        $this->config = new Config($parameters);
        $this->api = new Api($this->config);
    }

    /**
     * @param array|\Przelewy24\Transaction $transaction
     * @return \Przelewy24\Api\Response\RegisterTransactionResponse
     * @throws \Przelewy24\Exceptions\ApiResponseException
     */
    public function transaction($transaction): RegisterTransactionResponse
    {
        if (is_array($transaction)) {
            $transaction = new Transaction($transaction);
        }

        return $this->api->registerTransaction($transaction);
    }

    /**
     * @param array|\Przelewy24\TransactionVerification $verification
     * @return \Przelewy24\Api\Response\VerifyTransactionResponse
     * @throws \Przelewy24\Exceptions\ApiResponseException
     */
    public function verify($verification): VerifyTransactionResponse
    {
        if (is_array($verification)) {
            $verification = new TransactionVerification($verification);
        }

        return $this->api->verifyTransaction($verification);
    }

    /**
     * @return \Przelewy24\TransactionStatusNotification
     */
    public function handleWebhook(): TransactionStatusNotification
    {
        $data = $_POST;

        return new TransactionStatusNotification($data);
    }
}
