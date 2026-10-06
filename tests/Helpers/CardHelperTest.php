<?php

namespace Braspag\Test\Helpers;

use Braspag\Helpers\CardHelper;
use Braspag\Test\Shared\CardDataProvider;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CardHelperTest extends TestCase
{
    use CardDataProvider;

    #[DataProvider('validCardNumbersAuto')]
    #[DataProvider('validCardNumbersManual')]
    #[DataProvider('invalidCardNumbersAuto')]
    #[DataProvider('invalidCardNumbersManual')]
    public function test_validate_card_number(bool $valid, array $numbers)
    {
        foreach ($numbers as $number) {
            $this->assertSame($valid, CardHelper::validateCardNumber($number));
        }
    }

    #[DataProvider('invalidCardSecurityCode')]
    public function test_validate_card_security_code(bool $valid, array $codes)
    {
        foreach ($codes as $code) {
            $this->assertSame($valid, CardHelper::validateSecurityCode($code));
        }
    }

    #[DataProvider('invalidCardSecurityCode')]
    public function test_validate_card_brands(bool $valid, array $codes)
    {
        foreach ($codes as $code) {
            $this->assertSame($valid, CardHelper::validateSecurityCode($code));
        }
    }
}