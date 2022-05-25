<?php

namespace Braspag\Test\Builders\Cards;

use Braspag\Builders\Pagador\Cards\CreditCardBuilder;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Test\Shared\CardDataProvider;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CardBuilderTest extends TestCase
{
    use EntityDataProviders, CardDataProvider;

    /**
     * @dataProvider invalidCardNumbersAuto
     */
    public function test_invalid_number(bool $valid, array $numbers)
    {
        $this->expectException(BraspagBuilderException::class);

        CreditCardBuilder::create()
            ->setCardNumber($numbers[0]);
    }

    /**
     * @dataProvider invalidCardSecurityCode
     */
    public function test_invalid_security_code(bool $valid, array $codes)
    {
        $this->expectException(BraspagBuilderException::class);

        CreditCardBuilder::create()
            ->setSecurityCode($codes[0]);
    }
}
