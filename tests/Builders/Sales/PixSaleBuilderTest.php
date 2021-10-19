<?php

namespace Braspag\Test\Builders\Sales;

use Braspag\Entities\Customer;
use Braspag\Entities\Payment\PixPayment;
use Braspag\Entities\Sale;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class PixSaleBuilderTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validPixSale
     */
    public function test_pix_sale(array $properties)
    {
        $customerProperties = $properties['Customer'];
        $customer = new Customer($customerProperties['Name']);
        $this->fillObject($customer, $customerProperties);

        $paymentProperties = $properties['Payment'];
        $pixPayment = new PixPayment($paymentProperties['Provider'], $paymentProperties['Amount']);
        $this->fillObject($pixPayment, $paymentProperties);

        $merchantOrderId = $properties['MerchantOrderId'];

        $sale = new Sale($customer, $pixPayment, $merchantOrderId);

        $this->assertEquals($sale->Customer, $customer);
        $this->assertEquals($sale->Payment, $pixPayment);
        $this->assertEquals($sale->MerchantOrderId, $merchantOrderId);
    }
}
