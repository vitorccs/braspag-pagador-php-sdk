<?php
declare(strict_types=1);

namespace Braspag\Test\Exceptions;

use Braspag\Exceptions\BraspagRequestException;
use Braspag\Http\Resource;
use Braspag\SaleService;
use Braspag\Test\BaseTest;
use Braspag\Test\Shared\FakeResponse;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;

class BraspagRequestExceptionTest extends BaseTest
{
    public function resource(): Resource
    {
        return new SaleService();
    }

    /**
     * @dataProvider serverErrors
     * @dataProvider clientErrors
     * @dataProvider otherErrors
     */
    public function test_server_errors($fakeResponse, string $exceptionMessage = null)
    {
        $this->expectException(BraspagRequestException::class);
        $this->expectExceptionMessage($exceptionMessage);

        $resource = $this->getFakeResource($fakeResponse);

        /** @var SaleService $resource */
        $resource->create([]);
    }

    public function serverErrors(): array
    {
        return [
            'http_500' => [
                new FakeResponse(500),
                'Internal Server Error'
            ],
            'http_503' => [
                new FakeResponse(503),
                'Service Unavailable'
            ]
        ];
    }

    public function clientErrors(): array
    {
        return [
            'http_400' => [
                new FakeResponse(400),
                'Bad Request'
            ],
            'http_404' => [
                new FakeResponse(404),
                'Not Found'
            ],
            'http_403' => [
                new FakeResponse(403),
                'Forbidden'
            ]
        ];
    }

    public function otherErrors(): array
    {
        return [
            'transfer_exception' => [
                new TransferException('Transfer Exception'),
                'Transfer Exception'
            ],
            'connect_exception' => [
                new ConnectException('Connect Exception', new Request('POST', 'test')),
                'Connect Exception'
            ],
            'request_exception' => [
                new RequestException('Request Exception', new Request('POST', 'test')),
                'Request Exception'
            ]
        ];
    }
}
