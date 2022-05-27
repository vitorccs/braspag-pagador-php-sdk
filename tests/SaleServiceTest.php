<?php

namespace Braspag\Test;

use Braspag\SaleService;
use Braspag\Test\Shared\FakeResponse;

class SaleServiceTest extends BaseTest
{
    /**
     * @return SaleService
     */
    public function resource(): SaleService
    {
        return new SaleService();
    }

    /**
     * @dataProvider validPaymentData
     */
    public function test_create_sale(array $data, bool $checkSuccess, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var SaleService $resource */
        $response = $resource->create($data, $checkSuccess);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasAttribute('Payment', $response);
        $this->assertObjectHasAttribute('Status', $response->Payment);
        $this->assertEquals($fakeJson->Payment->Status, $response->Payment->Status);
    }

    /**
     * @dataProvider validRefundData
     */
    public function test_refund_sale(string $paymentId, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var SaleService $resource */
        $response = $resource->refund($paymentId);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasAttribute('Status', $response);
        $this->assertObjectHasAttribute('ProviderReturnMessage', $response);
        $this->assertEquals($fakeJson->Status, $response->Status);
        $this->assertEquals($fakeJson->ProviderReturnMessage, $response->ProviderReturnMessage);
    }

    public function validPaymentData(): array
    {
        return [
            'valid data with check enabled' => [
                [],
                true,
                new FakeResponse(200, [], '{"Payment": {"Status": 2, "ProviderReturnMessage": "Transacao capturada com sucesso"}}')
            ],
            'valid data with check disabled' => [
                [],
                false,
                new FakeResponse(200, [], '{"Payment": {"Status": 2, "ProviderReturnMessage": "Transacao capturada com sucesso"}}')
            ],
            'invalid data with check disabled' => [
                [],
                false,
                new FakeResponse(200, [], '{"Payment": {"Status": 0, "ProviderReturnMessage": "PROVIDER ERROR MESSAGE"}}')
            ]
        ];
    }

    public function validRefundData(): array
    {
        return [
            'valid data' => [
                'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                new FakeResponse(200, [], '{"Status": 10, "ProviderReturnMessage": "Operation Successful"}')
            ]
        ];
    }
}
