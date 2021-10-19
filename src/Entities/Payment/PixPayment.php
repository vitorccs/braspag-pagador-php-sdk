<?php

namespace Braspag\Entities\Payment;

use Braspag\Enum\PaymentTypes;

class PixPayment extends Payment
{
    /**
     * @return string
     */
    public function Type(): string
    {
        return PaymentTypes::PIX;
    }
}