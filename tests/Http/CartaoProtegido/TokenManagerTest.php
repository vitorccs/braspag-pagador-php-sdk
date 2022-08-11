<?php

namespace Braspag\Test\Http\CartaoProtegido;

use Braspag\Test\Shared\FakeTokenManagerFactory;
use PHPUnit\Framework\TestCase;

class TokenManagerTest extends TestCase
{
    public function test_retrieve_new_token()
    {
        $tokenManager = FakeTokenManagerFactory::create();

        $this->assertNotEmpty($tokenManager->getToken());
    }

    public function test_retrieve_same_token_while_not_expired()
    {
        $tokenManager = FakeTokenManagerFactory::create(1, 2, [
            'timestampOffset' => 0
        ]);

        $token1 = $tokenManager->getToken();
        $token2 = $tokenManager->getToken();
        $token3 = $tokenManager->getToken();
        $token4 = $tokenManager->getToken();

        $this->assertEquals($token1, $token2);
        $this->assertEquals($token2, $token3);
        $this->assertEquals($token3, $token4);
    }

    public function test_expire_token_for_expires_in()
    {
        $tokenManager = FakeTokenManagerFactory::create(1, 2, [
            'timestampOffset' => 0
        ]);

        $token1 = $tokenManager->getToken();
        sleep(1);
        $token2 = $tokenManager->getToken();

        $this->assertNotEquals($token1, $token2);
    }

    public function test_expire_token_for_timestamp_offset()
    {
        $tokenManager = FakeTokenManagerFactory::create(5, 2, [
            'timestampOffset' => 4
        ]);

        $token1 = $tokenManager->getToken();
        sleep(1);
        $token2 = $tokenManager->getToken();

        $this->assertNotEquals($token1, $token2);
    }
}
