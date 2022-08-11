<?php

namespace Braspag\Entities\Pagador\Payment;

use Braspag\Enum\PaymentTypes;

class PixPayment extends Payment
{
    /**
     * @var int|null
     */
    public ?int $QrCodeExpiration = null;

    /**
     * @return string
     */
    public function Type(): string
    {
        return PaymentTypes::PIX;
    }
}
