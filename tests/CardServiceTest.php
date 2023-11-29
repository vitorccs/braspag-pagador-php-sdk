<?php

namespace Braspag\Test;

use Braspag\CardService;
use Braspag\Test\Shared\FakeResponse;

class CardServiceTest extends BaseTest
{
    /**
     * @return CardService
     */
    public function resource(): CardService
    {
        return new CardService();
    }

    /**
     * @dataProvider validCardData
     */
    public function test_create_sale(array $data, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var CardService $resource */
        $response = $resource->createToken($data);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('TokenReference', $fakeJson);
    }

    /**
     * @dataProvider validTokenData
     */
    public function test_get_card_by_token(string $data, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var CardService $resource */
        $response = $resource->getCardByToken($data);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('Account', $fakeJson);
    }

    /**
     * @dataProvider validTokenData
     */
    public function test_get_token_by_alias(string $data, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var CardService $resource */
        $response = $resource->getTokenByAlias($data);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('TokenReference', $fakeJson);
    }

    /**
     * @dataProvider validSuspendTokenData
     */
    public function test_suspend_token(string $data, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var CardService $resource */
        $response = $resource->suspendToken($data);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('TokenReference', $fakeJson);
    }

    /**
     * @dataProvider validUnsuspendTokenData
     */
    public function test_unsuspend_token(string $data, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var CardService $resource */
        $response = $resource->unsuspendToken($data);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('TokenReference', $fakeJson);
    }

    /**
     * @dataProvider validRemoveTokenData
     */
    public function test_remove_token(string $data, FakeResponse $fakeResponse)
    {
        $resource = $this->getFakeResource($fakeResponse);

        /** @var CardService $resource */
        $response = $resource->removeToken($data);

        $fakeJson = $fakeResponse->getJsonResponse();

        $this->assertIsObject($response);
        $this->assertObjectHasProperty('TokenReference', $fakeJson);
    }

    /**
     * @return array[]
     */
    public function validCardData(): array
    {
        return [
            'valid data' => [
                [],
                new FakeResponse(201, [], '{"Alias":"","TokenReference":"e41988dc-afd0-435e-8b1e-365b9d73d8d8","ExpirationDate":"","Card":{}}')
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function validTokenData(): array
    {
        return [
            'valid data' => [
                '',
                new FakeResponse(201, [], '{"TokenReference": "79858893-435e-4d95-b637-cad5e9a96b29","Status":"","Provider":"","Account": {}}')
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function validAliasData(): array
    {
        return [
            'valid data' => [
                '',
                new FakeResponse(201, [], '{"TokenReference": "79858893-435e-4d95-b637-cad5e9a96b29"}')
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function validSuspendTokenData(): array
    {
        return [
            'valid data' => [
                '',
                new FakeResponse(201, [], '{"TokenReference":"3abd22d3-664a-4303-b25e-a76d2c809fde","Status":""}')
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function validUnsuspendTokenData(): array
    {
        return [
            'valid data' => [
                '',
                new FakeResponse(201, [], '{"TokenReference":"3abd22d3-664a-4303-b25e-a76d2c809fde","Status":""}')
            ]
        ];
    }

    /**
     * @return array[]
     */
    public function validRemoveTokenData(): array
    {
        return [
            'valid data' => [
                '',
                new FakeResponse(201, [], '{"TokenReference":"3abd22d3-664a-4303-b25e-a76d2c809fde","Status":""}')
            ]
        ];
    }
}
