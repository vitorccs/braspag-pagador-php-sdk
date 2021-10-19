<?php

namespace Braspag\Test\Exceptions;

use Braspag\Exceptions\BraspagValidationException;
use Braspag\Http\Resource;
use Braspag\SaleService;
use Braspag\Test\BaseTest;
use Braspag\Test\Shared\FakeResponse;

class BraspagValidationExceptionTest extends BaseTest
{
    public function resource(): Resource
    {
        return new SaleService();
    }

    /**
     * @dataProvider invalidPaymentData
     */
    public function test_create_sale_with_error(array        $data,
                                                bool         $checkSuccess,
                                                FakeResponse $fakeResponse)
    {
        $fakeJson = $fakeResponse->getJsonResponse();
        $this->expectException(BraspagValidationException::class);
        $this->expectExceptionMessage($fakeJson[0]->Message);
        $this->expectExceptionCode($fakeJson[0]->Code);

        $resource = $this->getFakeResource($fakeResponse);

        /** @var SaleService $resource */
        $resource->create($data, $checkSuccess);
    }

    public function invalidPaymentData(): array
    {
        return [
            'invalid data with check enabled' => [
                [],
                true,
                new FakeResponse(500, [], '[{"Code": 133,"Message": "Provider is not supported for this Payment Type"}]')
            ],
            'invalid data with check disabled' => [
                [],
                false,
                new FakeResponse(500, [], '[{"Code": 133,"Message": "Provider is not supported for this Payment Type"}]')
            ]
        ];
    }
}