<?php

namespace Braspag\Test\Builders\Pagador\Cards;

use Braspag\Builders\Pagador\Cards\CreditCardBuilder;
use Braspag\Entities\Pagador\Cards\CreditCard;
use Braspag\Enum\CreditCardBrands;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Test\Shared\CardDataProvider;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CreditCardBuilderTest extends TestCase
{
    use EntityDataProviders, CardDataProvider;

    #[DataProvider('validPagadorCreditCard')]
    public function teste_create_card(array $properties)
    {
        $card = CreditCardBuilder::create()
            ->setCardNumber($properties['CardNumber'])
            ->setHolder($properties['Holder'])
            ->setExpirationDate($properties['ExpirationDate'])
            ->setSecurityCode($properties['SecurityCode'])
            ->setBrand($properties['Brand'])
            ->setSaveCard($properties['SaveCard'])
            ->setAlias($properties['Alias'])
            ->get();

        $objCard = $this->fillObject(
            new CreditCard(),
            $properties
        );

        $this->assertEquals($card, $objCard);
    }

    #[DataProvider('invalidCardBrand')]
    #[DataProvider('invalidCreditCardBrand')]
    public function test_invalid_credit_card_brand(bool $valid, array $brands)
    {
        $this->expectException(BraspagBuilderException::class);

        foreach ($brands as $brand) {
            CreditCardBuilder::create()
                ->setBrand($brand);
        }
    }

    public static function invalidCreditCardBrand(): array
    {
        $samples = array_map('strtolower', CreditCardBrands::getArray());

        return [
            'invalid credit card brand' => [false, $samples]
        ];
    }
}
