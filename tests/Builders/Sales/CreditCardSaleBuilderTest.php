<?php

namespace Braspag\Test\Builders\Sales;

use Braspag\Entities\Cards\CreditCard;
use Braspag\Entities\Customer;
use Braspag\Entities\Payment\CreditCardPayment;
use Braspag\Entities\Sale;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CreditCardSaleBuilderTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validCreditCardSale
     */
    public function test_pix_sale(array $properties)
    {
        $customerProperties = $properties['Customer'];
        $customer = new Customer($customerProperties['Name']);
        $this->fillObject($customer, $customerProperties);

        $paymentProperties = $properties['Payment'];
        $creditCardPayment = new CreditCardPayment($paymentProperties['Provider'], $paymentProperties['Amount']);
        $this->fillObject($creditCardPayment, $paymentProperties);

        $creditCard = new CreditCard();
        $this->fillObject($creditCard, $properties['Payment']['CreditCard']);
        $creditCardPayment->CreditCard = $creditCard;

        $merchantOrderId = $properties['MerchantOrderId'];

        $sale = new Sale($customer, $creditCardPayment, $merchantOrderId);

        $this->assertEquals($sale->Customer, $customer);
        $this->assertEquals($sale->Payment, $creditCardPayment);
        $this->assertEquals($sale->MerchantOrderId, $merchantOrderId);
    }
}
