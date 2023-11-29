<?php

namespace Braspag\Entities\Pagador\Payment;

use Braspag\Enum\PaymentTypes;

class PixPayment extends Payment
{
    public ?int $QrCodeExpiration = null;

    public function Type(): string
    {
        return PaymentTypes::PIX;
    }
}
