<?php

namespace Braspag\Entities;

use Braspag\Entities\Payment\Payment;

class Sale
{
    /**
     * @var Customer
     */
    public Customer $Customer;

    /**
     * @var Payment
     */
    public Payment $Payment;

    /**
     * @var string
     */
    public string $MerchantOrderId;

    /**
     * @param Customer $customer
     * @param Payment $payment
     * @param string $merchantOrderId
     */
    public function __construct(Customer $customer,
                                Payment  $payment,
                                string   $merchantOrderId)
    {
        $this->Customer = $customer;
        $this->Payment = $payment;
        $this->MerchantOrderId = $merchantOrderId;
    }
}