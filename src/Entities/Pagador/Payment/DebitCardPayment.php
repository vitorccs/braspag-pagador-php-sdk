<?php

namespace Braspag\Entities\Pagador\Payment;

use Braspag\Entities\Pagador\Cards\Card;
use Braspag\Enum\PaymentTypes;

class DebitCardPayment extends Payment
{
    public ?Card $DebitCard = null;

    public int $Installments = 1;

    public ?string $ReturnUrl = null;

    public function Type(): string
    {
        return PaymentTypes::DEBIT_CARD;
    }
}
