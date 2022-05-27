<?php

namespace Braspag\Test\Builders\Pagador\Cards;

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

        foreach ($numbers as $number) {
            CreditCardBuilder::create()
                ->setCardNumber($number);
        }
    }
}
