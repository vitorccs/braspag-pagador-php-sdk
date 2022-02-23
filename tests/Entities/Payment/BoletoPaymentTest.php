<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Payment;

use Braspag\Entities\Payment\BoletoPayment;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class BoletoPaymentTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validPixPayment
     */
    public function test_properties(array $properties)
    {
        $pixPayment = new BoletoPayment($properties['Provider'], $properties['Amount']);

        $this->fillObject($pixPayment, $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasAttribute($property, $pixPayment);
            $this->assertEquals($pixPayment->{$property}, $value);
        }
    }
}
