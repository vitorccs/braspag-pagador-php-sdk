<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Pagador\Payment;

use Braspag\Entities\Pagador\Payment\PixPayment;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class PixPaymentTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validPixPayment
     */
    public function test_properties(array $properties)
    {
        $pixPayment = new PixPayment($properties['Provider'], $properties['Amount']);

        $this->fillObject($pixPayment, $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasAttribute($property, $pixPayment);
            $this->assertEquals($pixPayment->{$property}, $value);
        }
    }
}
