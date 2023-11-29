<?php

namespace Braspag\Test;

use Braspag\QueryService;
use Braspag\Test\Shared\FakeResponse;

class QueryServiceTest extends BaseTest
{
    /**
     * @return QueryService
     */
    public function resource(): QueryService
    {
        return new QueryService();
    }

    /**
     * @dataProvider validPaymentId
     */
    public function test_get_by_payment_id(string $paymentId, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var QueryService $resource */
        $response = $resource->getByPaymentId($paymentId);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('Payment', $response);
        $this->assertObjectHasProperty('Status', $response->Payment);
        $this->assertEquals($fakeJson->Payment->Status, $response->Payment->Status);
    }

    /**
     * @dataProvider validMerchantOrderId
     */
    public function test_get_by_merchant_order_id(string $merchantOrderId, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var QueryService $resource */
        $response = $resource->getByMerchantOrderId($merchantOrderId);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('ReasonCode', $response);
        $this->assertObjectHasProperty('ReasonMessage', $response);
        $this->assertObjectHasProperty('Payments', $response);

        $this->assertEquals($fakeJson->ReasonCode, $response->ReasonCode);
        $this->assertEquals($fakeJson->ReasonMessage, $response->ReasonMessage);
        $this->assertNotEmpty($response->Payments);
    }

    /**
     * @dataProvider validRecurrentPaymentId
     */
    public function test_get_by_recurrent_payment_id(string $recurrentPaymentId, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var QueryService $resource */
        $response = $resource->getByRecurrentPaymentId($recurrentPaymentId);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('RecurrentPayment', $response);
        $this->assertObjectHasProperty('SuccessfulRecurrences', $response->RecurrentPayment);
        $this->assertObjectHasProperty('Status', $response->RecurrentPayment);

        $this->assertEquals($fakeJson->RecurrentPayment->SuccessfulRecurrences, $response->RecurrentPayment->SuccessfulRecurrences);
        $this->assertEquals($fakeJson->RecurrentPayment->Status, $response->RecurrentPayment->Status);
    }

    public function validPaymentId(): array
    {
        return [
            'valid' => [
                'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                new FakeResponse(200, [], '{"Payment": {"Status": 12, "ProviderReturnMessage": "OPERACAO SUCESSO"}}')
            ]
        ];
    }

    public function validMerchantOrderId(): array
    {
        return [
            'valid' => [
                'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                new FakeResponse(200, [], '{"ReasonCode": 0, "ReasonMessage": "Successful", "Payments": [{ "PaymentId": "1"}]}')
            ]
        ];
    }

    public function validRecurrentPaymentId(): array
    {
        return [
            'valid' => [
                'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',
                new FakeResponse(200, [], '{"RecurrentPayment": { "SuccessfulRecurrences": 1, "Status": 1 }}')
            ]
        ];
    }
}
