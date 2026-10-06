<?php

namespace Braspag\Test\Builders\Shared;

use Braspag\Builders\CartaoProtegido\CardBuilder;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Test\Shared\CardDataProvider;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CardBuilderTraitTest extends TestCase
{
    use EntityDataProviders, CardDataProvider;

    #[DataProvider('invalidExpirationDate')]
    public function test_invalid_expiration_date(bool $valid, array $expirationDates)
    {
        $this->expectException(BraspagBuilderException::class);

        foreach ($expirationDates as $expirationDate) {
            CardBuilder::create()
                ->setSecurityCode($expirationDate);
        }
    }

    public function test_invalid_holder()
    {
        $this->expectException(BraspagBuilderException::class);

        CardBuilder::create()
            ->setHolder('');
    }

    #[DataProvider('invalidCardSecurityCode')]
    public function test_invalid_security_code(bool $valid, array $codes)
    {
        $this->expectException(BraspagBuilderException::class);

        foreach ($codes as $code) {
            CardBuilder::create()
                ->setSecurityCode($code);
        }
    }

    #[DataProvider('invalidCardNumbersAuto')]
    public function test_invalid_card_number(bool $valid, array $numbers)
    {
        $this->expectException(BraspagBuilderException::class);

        foreach ($numbers as $number) {
            CardBuilder::create()
                ->setCardNumber($number);
        }
    }
}
