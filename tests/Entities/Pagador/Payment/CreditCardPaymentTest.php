<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Pagador\Payment;

use Braspag\Entities\Pagador\Cards\CreditCard;
use Braspag\Entities\Pagador\Payment\CreditCardPayment;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CreditCardPaymentTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validCreditCardPayment
     */
    public function test_properties(array $properties)
    {
        $creditCardPayment = new CreditCardPayment($properties['Provider'], $properties['Amount']);
        $this->fillObject($creditCardPayment, $properties);

        $creditCard = new CreditCard();
        $this->fillObject($creditCard, $properties['CreditCard']);
        $creditCardPayment->CreditCard = $creditCard;

        foreach ($properties as $property => $value) {
            $this->assertObjectHasProperty($property, $creditCardPayment);
            $instanceValue = $creditCardPayment->{$property};
            $instanceValue = is_array($value) ? (array)$instanceValue : $instanceValue;
            $this->assertEquals($instanceValue, $value);
        }
    }
}
