<?php

namespace Braspag\Test\Builders\CartaoProtegido;

use Braspag\Builders\CartaoProtegido\CardBuilder;
use Braspag\Entities\CartaoProtegido\Card;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Test\Shared\CardDataProvider;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CardBuilderTest extends TestCase
{
    use EntityDataProviders, CardDataProvider;

    /**
     * @dataProvider validCartaoProtegidoCard
     */
    public function teste_create_card(array $properties)
    {
        $card = CardBuilder::create()
            ->setCardNumber($properties['Number'])
            ->setHolder($properties['Holder'])
            ->setExpirationDate($properties['ExpirationDate'])
            ->setSecurityCode($properties['SecurityCode'])
            ->setAlias($properties['Alias'])
            ->get();

        $objCard = $this->fillObject(
            new Card(),
            $properties
        );

        $this->assertEquals($card, $objCard);
    }

    /**
     * @dataProvider invalidCardNumbersAuto
     */
    public function test_invalid_number(bool $valid, array $numbers)
    {
        $this->expectException(BraspagBuilderException::class);

        foreach ($numbers as $number) {
            CardBuilder::create()
                ->setCardNumber($number);
        }
    }
}
