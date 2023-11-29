<?php

namespace Braspag;

use Braspag\Entities\Pagador\Parameters;
use Braspag\Exceptions\BraspagException;
use Braspag\Exceptions\BraspagRequestException;
use Braspag\Exceptions\BraspagValidationException;
use Braspag\Http\Factories\Pagador\ClientFactory;
use Braspag\Http\Resource;

class QueryService extends Resource
{
    public function __construct(?Parameters $parameters = null)
    {
        $client = ClientFactory::create(true, $parameters);

        parent::__construct($client);
    }

    /**
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    public function getByPaymentId(string $paymentId): ?object
    {
        return $this->api->get("/v2/sales/{$paymentId}");
    }

    /**
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    public function getByMerchantOrderId(string $merchantOrderId): ?object
    {
        return $this->api->get('/v2/sales', [
            'merchantOrderId' => $merchantOrderId
        ]);
    }

    /**
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    public function getByRecurrentPaymentId(string $recurrentPaymentId): ?object
    {
        return $this->api->get("/v2/RecurrentPayment/{$recurrentPaymentId}");
    }
}
