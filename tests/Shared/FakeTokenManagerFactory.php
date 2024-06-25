<?php

namespace Braspag\Test\Shared;

use Braspag\Entities\CartaoProtegido\Parameters;
use Braspag\Http\Factories\CartaoProtegido\TokenManager;
use GuzzleHttp\Handler\MockHandler;

class FakeTokenManagerFactory
{
    const RESET_PROPERTIES = [
        'token' => 'null',
        'lastTimestamp' => 0,
        'expiresIn' => 0,
        'timestampOffset' => 60
    ];

    public static function create(int   $expiresIn = 1,
                                  int   $quantity = 1,
                                  array $properties = []): TokenManager
    {
        $handler = static::getHandler($expiresIn, $quantity);
        $parameters = new Parameters(
            ' ',
            ' ',
            ' '
        );

        $tokenManager = new TokenManager($parameters);
        $tokenManager->setFakeClient($handler);

        static::resetProperties($tokenManager, $properties);

        return $tokenManager;
    }

    private static function getHandler(int $expiresIn,
                                       int $quantity): MockHandler
    {
        $handler = new MockHandler([]);

        for ($i = 0; $i < $quantity; $i++) {
            $response = new FakeResponse(200, [], json_encode([
                "access_token" => uniqid(),
                "expires_in" => $expiresIn
            ]));
            $handler->append($response);
        }

        return $handler;
    }

    private static function resetProperties(TokenManager $tokenManager,
                                            array        $properties = []): void
    {
        $obj = new \ReflectionObject($tokenManager);

        $properties = array_merge(self::RESET_PROPERTIES, $properties);

        foreach ($properties as $key => $value) {
            // make properties public
            $property = $obj->getProperty($key);
            $property->setAccessible(true);
            $property->setValue($tokenManager, $value);
        }
    }
}
