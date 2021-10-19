<?php

namespace Braspag\Test\Builders\Cards;

use Braspag\Builders\Cards\CreditCardBuilder;
use Braspag\Entities\Cards\CreditCard;
use Braspag\Enum\CreditCardBrands;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Test\Shared\CardDataProvider;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CreditCardBuilderTest extends TestCase
{
    use EntityDataProviders, CardDataProvider;

    /**
     * @dataProvider validCreditCard
     */
    public function test_credit_properties(array $properties)
    {
        $instanceCard = new CreditCard();

        $this->fillObject($instanceCard, $properties);

        $builderCard = CreditCardBuilder::create()
            ->setCardNumber($properties['CardNumber'])
            ->setHolder($properties['Holder'])
            ->setExpirationDate($properties['ExpirationDate'])
            ->setSecurityCode($properties['SecurityCode'])
            ->setBrand($properties['Brand'])
            ->setSaveCard($properties['SaveCard'])
            ->setAlias($properties['Alias'])
            ->get();

        foreach (array_keys($properties) as $property) {
            $instance = $instanceCard->{$property};
            $builder = $builderCard->{$property};
            $this->assertEquals($builder, $instance);
        }
    }

    /**
     * @dataProvider invalidCardBrand
     * @dataProvider invalidCreditCardBrand
     */
    public function test_invalid_credit_card_brand(bool $valid, array $brands)
    {
        $this->expectException(BraspagBuilderException::class);

        foreach ($brands as $brand) {
            CreditCardBuilder::create()
                ->setBrand($brand);
        }
    }

    public function invalidCreditCardBrand(): array
    {
        $samples = array_map('strtolower', CreditCardBrands::getArray());

        return [
            'invalid' => [false, $samples]
        ];
    }
}