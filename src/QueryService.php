<?php

namespace Braspag;

use Braspag\Entities\Pagador\Parameters;
use Braspag\Exceptions\BraspagException;
use Braspag\Exceptions\BraspagNotFoundException;
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
     * @throws BraspagNotFoundException
     */
    public function getByPaymentId(string $paymentId): object
    {
        return $this->makeQueryRequest("/v2/sales/{$paymentId}");
    }

    /**
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     * @throws BraspagNotFoundException
     */
    public function getByMerchantOrderId(string $merchantOrderId): object
    {
        return $this->makeQueryRequest('/v2/sales', [
            'merchantOrderId' => $merchantOrderId
        ]);
    }

    /**
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     * @throws BraspagNotFoundException
     */
    public function getByRecurrentPaymentId(string $recurrentPaymentId): object
    {
        return $this->makeQueryRequest("/v2/RecurrentPayment/{$recurrentPaymentId}");
    }

    /**
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     * @throws BraspagNotFoundException
     */
    private function makeQueryRequest(string $endpoint,
                                      array  $query = []): object
    {
        try {
            return $this->api->get($endpoint, $query);
        } catch (BraspagRequestException $e) {
            $isNotFoundError = $e->getCode() === BraspagNotFoundException::HTTP_NOT_FOUND;

            $isNotFoundError
                ? throw new BraspagNotFoundException()
                : throw $e;
        }
    }
}
