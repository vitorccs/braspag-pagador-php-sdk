<?php

namespace Braspag\Test\Builders\Cards;

use Braspag\Builders\Pagador\Cards\DebitCardBuilder;
use Braspag\Entities\Pagador\Cards\DebitCard;
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
        $card = DebitCardBuilder::create()
            ->setCardNumber($properties['CardNumber'])
            ->setHolder($properties['Holder'])
            ->setExpirationDate($properties['ExpirationDate'])
            ->setSecurityCode($properties['SecurityCode'])
            ->setBrand($properties['Brand'])
            ->setSaveCard($properties['SaveCard'])
            ->setAlias($properties['Alias'])
            ->get();

        $objCard = $this->fillObject(
            new DebitCard(),
            $properties
        );

        $this->assertEquals($card, $objCard);
    }

    /**
     * @dataProvider invalidCardBrand
     * @dataProvider invalidDebitCardBrand
     */
    public function test_invalid_debit_card_brand(bool $valid, array $brands)
    {
        $this->expectException(BraspagBuilderException::class);

        foreach ($brands as $brand) {
            DebitCardBuilder::create()
                ->setBrand($brand);
        }
    }

    public function invalidDebitCardBrand(): array
    {
        $samples = array_map('strtolower', DebitCardBrands::getArray());

        return [
            'invalid' => [false, $samples]
        ];
    }
}
