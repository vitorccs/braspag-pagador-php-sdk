<?php

namespace Braspag\Test\Builders\Sales;

use Braspag\Builders\CustomerBuilder;
use Braspag\Builders\Sales\PixSaleBuilder;
use Braspag\Entities\Payment\PixPayment;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class PixSaleBuilderTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validPixSale
     */
    public function test_create_pix(array $properties)
    {
        $merchantOrderId = $properties['MerchantOrderId'];
        $customerProps = $properties['Customer'];
        $paymentProps = $properties['Payment'];

        $customer = CustomerBuilder::create($customerProps['Name'])->get();

        $sale = PixSaleBuilder::create($paymentProps['Provider'], $paymentProps['Amount'])
            ->withMerchantOrderId($merchantOrderId)
            ->withCustomer($customer)
            ->get();

        $objPayment = $this->fillObject(
            new PixPayment($paymentProps['Provider'], $paymentProps['Amount']),
            $paymentProps
        );

        $this->assertEquals($sale->Payment, $objPayment);
        $this->assertEquals($sale->MerchantOrderId, $merchantOrderId);
    }
}
