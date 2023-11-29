<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Pagador\Cards;

use Braspag\Entities\Pagador\Cards\CreditCard;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CreditCardTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validPagadorCreditCard
     */
    public function test_credit_properties(array $properties)
    {
        $creditCard = new CreditCard();

        $this->fillObject($creditCard, $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasProperty($property, $creditCard);
            $this->assertEquals($creditCard->{$property}, $value);
        }
    }
}
