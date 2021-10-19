<?php

namespace Braspag\Test\Builders\Cards;

use Braspag\Builders\Cards\DebitCardBuilder;
use Braspag\Entities\Cards\DebitCard;
use Braspag\Enum\DebitCardBrands;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Test\Shared\CardDataProvider;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class DebitCardBuilderTest extends TestCase
{
    use EntityDataProviders, CardDataProvider;

    /**
     * @dataProvider validDebitCard
     */
    public function test_debit_properties(array $properties)
    {
        $instanceCard = new DebitCard();

        $this->fillObject($instanceCard, $properties);

        $builderCard = DebitCardBuilder::create()
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
            DebitCardBuilder::create()->setBrand($brand);
        }
    }

    public function invalidCreditCardBrand(): array
    {
        $samples = array_map('strtolower', DebitCardBrands::getArray());

        return [
            'invalid' => [false, $samples]
        ];
    }
}