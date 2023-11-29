<?php

namespace Braspag;

use Braspag\Entities\Pagador\Parameters;
use Braspag\Entities\Pagador\Sale;
use Braspag\Exceptions\BraspagException;
use Braspag\Exceptions\BraspagProviderException;
use Braspag\Exceptions\BraspagRequestException;
use Braspag\Exceptions\BraspagValidationException;
use Braspag\Http\Factories\Pagador\ClientFactory;
use Braspag\Http\Resource;

class SaleService extends Resource
{
    public function __construct(?Parameters $parameters = null)
    {
        $client = ClientFactory::create(false, $parameters);

        parent::__construct($client);
    }

    /**
     * @throws BraspagProviderException
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    public function create(array|Sale $data,
                           bool       $checkSuccess = false): ?object
    {
        $response = $this->api->post('/v2/sales', $data);

        if ($checkSuccess) {
            $this->checkForProviderException($response);
        }

        return $response;
    }

    /**
     * @throws BraspagProviderException
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    public function refund(string $paymentId,
                           ?int   $amount = null): ?object
    {
        return $this->api->put("/v2/sales/{$paymentId}/void", [
            'amount' => $amount
        ]);
    }

    /**
     * Check for Providers errors
     *
     * FORMAT: { "Payment": { "Status": int }
     *
     * @throws BraspagProviderException
     */
    private function checkForProviderException(object|array|null $jsonResponse): void
    {
        $providerData = $jsonResponse->Payment ?? null;
        $providerStatusCode = $providerData->Status ?? null;

        if (!is_numeric($providerStatusCode) || intval($providerStatusCode) !== 0) {
            return;
        }

        $providerMessage = $providerData->ProviderReturnMessage ?? null;

        throw new BraspagProviderException($providerMessage, $jsonResponse);
    }
}
