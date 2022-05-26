<?php

namespace Braspag;

use Braspag\Entities\Pagador\Parameters;
use Braspag\Http\Factories\Pagador\ClientFactory;
use Braspag\Http\Resource;

class QueryService extends Resource
{
    /**
     * @param Parameters|null $parameters
     */
    public function __construct(?Parameters $parameters = null)
    {
        parent::__construct(ClientFactory::create(true, $parameters));
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
