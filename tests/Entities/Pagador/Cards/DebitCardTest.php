<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Pagador\Cards;

use Braspag\Entities\Pagador\Cards\DebitCard;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class DebitCardTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validDebitCard
     */
    public function test_debit_properties(array $properties)
    {
        $debitCard = new DebitCard();

        $this->fillObject($debitCard, $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasProperty($property, $debitCard);
            $this->assertEquals($debitCard->{$property}, $value);
        }
    }
}
