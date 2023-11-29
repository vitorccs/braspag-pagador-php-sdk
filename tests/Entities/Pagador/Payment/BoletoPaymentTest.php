<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Pagador\Payment;

use Braspag\Entities\Pagador\Payment\BoletoPayment;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class BoletoPaymentTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validBoletoPayment
     */
    public function test_properties(array $properties)
    {
        $pixPayment = new BoletoPayment($properties['Provider'], $properties['Amount']);

        $this->fillObject($pixPayment, $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasProperty($property, $pixPayment);
            $this->assertEquals($pixPayment->{$property}, $value);
        }
    }
}
