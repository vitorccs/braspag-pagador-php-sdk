<?php

namespace Braspag\Entities\Pagador;

use Braspag\Entities\Pagador\Payment\Payment;

class Sale
{
    public Customer $Customer;

    public Payment $Payment;

    public string $MerchantOrderId;

    public function __construct(Customer $customer,
                                Payment  $payment,
                                string   $merchantOrderId)
    {
        $this->Customer = $customer;
        $this->Payment = $payment;
        $this->MerchantOrderId = $merchantOrderId;
    }
}
