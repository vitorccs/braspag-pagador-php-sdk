<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Pagador\Payment;

use Braspag\Entities\Pagador\Cards\DebitCard;
use Braspag\Entities\Pagador\Payment\DebitCardPayment;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class DebitCardPaymentTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validDebitCardPayment
     */
    public function test_properties(array $properties)
    {
        $debitCardPayment = new DebitCardPayment($properties['Provider'], $properties['Amount']);
        $this->fillObject($debitCardPayment, $properties);

        $debitCard = new DebitCard();
        $this->fillObject($debitCard, $properties['DebitCard']);
        $debitCardPayment->DebitCard = $debitCard;

        foreach ($properties as $property => $value) {
            $this->assertObjectHasProperty($property, $debitCardPayment);
            $instanceValue = $debitCardPayment->{$property};
            $instanceValue = is_array($value) ? (array)$instanceValue : $instanceValue;
            $this->assertEquals($instanceValue, $value);
        }
    }
}
