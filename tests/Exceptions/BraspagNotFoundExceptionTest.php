<?php

namespace Braspag\Test\Exceptions;

use Braspag\Exceptions\BraspagNotFoundException;
use Braspag\Exceptions\BraspagRequestException;
use Braspag\QueryService;
use Braspag\Test\Shared\FakeResponse;
use Braspag\Test\Shared\FakeResponseHelper;
use Braspag\Test\Shared\ParametersHelper;
use PHPUnit\Framework\TestCase;

class BraspagNotFoundExceptionTest extends TestCase
{
    /**
     * Run once before tests
     */
    public function setUp(): void
    {
        ParametersHelper::setEnv();
    }

    /**
     * @dataProvider notFoundErrors
     * @dataProvider clientErrors
     * @dataProvider serverErrors
     */
    public function test_by_merchant_order_id(FakeResponse $fakeResponse,
                                              bool         $isNotFoundError)
    {
        $resource = $this->expectExceptions($fakeResponse, $isNotFoundError);

        $resource->getByMerchantOrderId('');
    }

    /**
     * @dataProvider notFoundErrors
     * @dataProvider clientErrors
     * @dataProvider serverErrors
     */
    public function test_by_recurrent_payment_id(FakeResponse $fakeResponse,
                                                 bool         $isNotFoundError)
    {
        $resource = $this->expectExceptions($fakeResponse, $isNotFoundError);

        $resource->getByRecurrentPaymentId('');
    }

    /**
     * @dataProvider notFoundErrors
     * @dataProvider clientErrors
     * @dataProvider serverErrors
     */
    public function test_by_payment_id(FakeResponse $fakeResponse,
                                       bool         $isNotFoundError)
    {
        $resource = $this->expectExceptions($fakeResponse, $isNotFoundError);

        $resource->getByPaymentId('');
    }

    private function expectExceptions(FakeResponse $fakeResponse,
                                      bool         $isNotFoundError): QueryService
    {
        $isNotFoundError
            ? $this->expectException(BraspagNotFoundException::class)
            : $this->expectException(BraspagRequestException::class);

        $this->expectExceptionCode($fakeResponse->getStatusCode());

        /** @var QueryService $resource */
        $resource = FakeResponseHelper::addMockHandler(new QueryService(), $fakeResponse);

        return $resource;
    }

    public function notFoundErrors(): array
    {
        return [
            '404' => [
                new FakeResponse(BraspagNotFoundException::HTTP_NOT_FOUND, []),
                true,
            ]
        ];
    }

    public function clientErrors(): array
    {
        return [
            '400 Bad Request' => [
                new FakeResponse(400, []),
                false,
            ],
            '401 Unauthorized' => [
                new FakeResponse(401, []),
                false,
            ],
            '403 Forbidden' => [
                new FakeResponse(403, []),
                false,
            ],
            '422 Unprocessable Content' => [
                new FakeResponse(422, []),
                false,
            ],
            '499' => [
                new FakeResponse(499, []),
                false,
            ],
        ];
    }

    public function serverErrors(): array
    {
        return [
            '500 Internal Server Error' => [
                new FakeResponse(500, []),
                false,
            ],
            '502 Bad Gateway' => [
                new FakeResponse(502, []),
                false,
            ],
            '503 Service Unavailable' => [
                new FakeResponse(503, []),
                false,
            ],
            '504 Gateway Timeout' => [
                new FakeResponse(504, []),
                false,
            ],
            '599' => [
                new FakeResponse(599, []),
                false,
            ],
        ];
    }
}
