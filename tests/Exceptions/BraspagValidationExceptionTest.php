<?php

namespace Braspag\Test\Exceptions;

use Braspag\CardService;
use Braspag\Exceptions\BraspagValidationException;
use Braspag\SaleService;
use Braspag\Test\Shared\FakeResponse;
use Braspag\Test\Shared\FakeResponseHelper;
use Braspag\Test\Shared\ParametersHelper;
use PHPUnit\Framework\TestCase;

class BraspagValidationExceptionTest extends TestCase
{
    /**
     * Run once before tests
     */
    public function setUp(): void
    {
        ParametersHelper::setEnv();
    }

    /**
     * @dataProvider apiPagadorValidationErrors
     */
    public function test_pagador_validation_errors(bool         $checkSuccess,
                                                   FakeResponse $fakeResponse)
    {
        $fakeJson = $fakeResponse->getJsonResponse();
        $this->expectException(BraspagValidationException::class);
        $this->expectExceptionMessage($fakeJson[0]->Message);
        $this->expectExceptionCode($fakeJson[0]->Code);

        $resource = FakeResponseHelper::addMockHandler(new SaleService(), $fakeResponse);

        /** @var SaleService $resource */
        $resource->create([], $checkSuccess);
    }

    /**
     * @dataProvider apiCartaoProtegidoValidationErrors
     */
    public function test_cartao_protegido_validation_errors(FakeResponse $fakeResponse)
    {
        $fakeJson = $fakeResponse->getJsonResponse();
        $message = $fakeJson->Errors[0]->Message;
        $code = $fakeJson->Errors[0]->Code;

        $this->expectException(BraspagValidationException::class);
        $this->expectExceptionMessage($message);
        $this->expectExceptionCode(is_numeric($code) ? $code : 0);

        $resource = FakeResponseHelper::addMockHandler(new CardService(), $fakeResponse);

        /** @var CardService $resource */
        $resource->createToken([]);
    }

    public function apiPagadorValidationErrors(): array
    {
        return [
            'invalid data with check enabled' => [
                true,
                new FakeResponse(500, [], '[{"Code": 133,"Message": "Provider is not supported for this Payment Type"}]')
            ],
            'invalid data with check disabled' => [
                false,
                new FakeResponse(500, [], '[{"Code": 133,"Message": "Provider is not supported for this Payment Type"}]')
            ]
        ];
    }

    public function apiCartaoProtegidoValidationErrors(): array
    {
        return [
            'invalid data with check enabled' => [
                new FakeResponse(400, [], '{"Errors": [{"Code": "CP903","Message": "Token alias already exists"}]}')
            ]
        ];
    }
}
