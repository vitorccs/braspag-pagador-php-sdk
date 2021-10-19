<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Cards;

use Braspag\Entities\Cards\CreditCard;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CreditCardTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validCreditCard
     */
    public function test_credit_properties(array $properties)
    {
        $creditCard = new CreditCard();

        $this->fillObject($creditCard, $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasAttribute($property, $creditCard);
            $this->assertEquals($creditCard->{$property}, $value);
        }
    }
}