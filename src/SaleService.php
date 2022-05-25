<?php

namespace Braspag;

use Braspag\Entities\Pagador\Sale;
use Braspag\Exceptions\BraspagProviderException;
use Braspag\Http\Resource;

class SaleService extends Resource
{
    /**
     * @param Sale|array $data
     * @param bool $checkSuccess
     * @return object|null
     * @throws BraspagProviderException
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function create($data, bool $checkSuccess = false): ?object
    {
        $response = $this->api->post('/v2/sales', $data);

        if ($checkSuccess) {
            $this->checkForProviderException($response);
        }

        return $response;
    }

    /**
     * @param string $paymentId
     * @param int|null $amount
     * @return object|null
     * @throws BraspagProviderException
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function refund(string $paymentId, int $amount = null): ?object
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
     * @param object|array|null $jsonResponse
     * @throws BraspagProviderException
     */
    private function checkForProviderException($jsonResponse = null)
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
