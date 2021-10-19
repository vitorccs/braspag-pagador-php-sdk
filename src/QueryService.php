<?php

namespace Braspag;

use Braspag\Http\Resource;

class QueryService extends Resource
{
    /**
     * @return bool
     */
    public static function isQueryApi(): bool
    {
        return true;
    }

    /**
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function getByPaymentId(string $paymentId)
    {
        return $this->api->get("/v2/sales/{$paymentId}");
    }

    /**
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function getByMerchantOrderId(string $merchantOrderId)
    {
        return $this->api->get('/v2/sales', [
            'merchantOrderId' => $merchantOrderId
        ]);
    }

    /**
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function getByRecurrentPaymentId(string $recurrentPaymentId)
    {
        return $this->api->get("/v2/RecurrentPayment/{$recurrentPaymentId}");
    }
}