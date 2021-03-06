<?php

namespace Braspag\Test\Builders\Sales;

use Braspag\Builders\CustomerBuilder;
use Braspag\Builders\Sales\CreditCardSaleBuilder;
use Braspag\Entities\Payment\CreditCardPayment;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CreditCardSaleBuilderTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validCreditCardSale
     */
    public function test_create_credit_card(array $properties)
    {
        $merchantOrderId = $properties['MerchantOrderId'];
        $customerProps = $properties['Customer'];
        $paymentProps = $properties['Payment'];

        $customer = CustomerBuilder::create($customerProps['Name'])->get();

        $sale = CreditCardSaleBuilder::create($paymentProps['Provider'], $paymentProps['Amount'])
            ->withMerchantOrderId($merchantOrderId)
            ->withCustomer($customer)
            ->setInstallments($paymentProps['Installments'])
            ->setCurrency($paymentProps['Currency'])
            ->setCountry($paymentProps['Country'])
            ->setInterest($paymentProps['Interest'])
            ->setCapture($paymentProps['Capture'])
            ->setAuthenticate($paymentProps['Authenticate'])
            ->setRecurrent($paymentProps['Recurrent'])
            ->setSoftDescriptor($paymentProps['SoftDescriptor'])
            ->setDoSplit($paymentProps['DoSplit'])
            ->get();

        $objPayment = $this->fillObject(
            new CreditCardPayment($paymentProps['Provider'], $paymentProps['Amount']),
            $paymentProps
        );

        $this->assertEquals($sale->Payment, $objPayment);
        $this->assertEquals($sale->MerchantOrderId, $merchantOrderId);
    }
}
