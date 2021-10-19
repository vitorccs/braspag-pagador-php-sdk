<?php

namespace Braspag\Test\Exceptions;

use Braspag\Exceptions\BraspagProviderException;
use Braspag\Http\Resource;
use Braspag\SaleService;
use Braspag\Test\BaseTest;
use Braspag\Test\Shared\FakeResponse;

class BraspagProviderExceptionTest extends BaseTest
{
    public function resource(): Resource
    {
        return new SaleService();
    }

    /**
     * @dataProvider invalidPaymentData
     */
    public function test_create_sale(array        $data,
                                     bool         $checkSuccess,
                                     FakeResponse $fakeResponse)
    {
        $fakeJson = $fakeResponse->getJsonResponse();
        $resource = $this->getFakeResource($fakeResponse);

        $this->expectException(BraspagProviderException::class);
        $this->expectExceptionMessage($fakeJson->Payment->ProviderReturnMessage);
        $this->expectExceptionCode($fakeJson->Payment->Status);

        /** @var SaleService $resource */
        $resource->create($data, $checkSuccess);
    }

    public function invalidPaymentData(): array
    {
        return [
            'invalid data with check enabled' => [
                [],
                true,
                new FakeResponse(200, [], '{"Payment": {"Status": 0, "ProviderReturnMessage": "PROVIDER ERROR MESSAGE"}}')
            ]
        ];
    }
}