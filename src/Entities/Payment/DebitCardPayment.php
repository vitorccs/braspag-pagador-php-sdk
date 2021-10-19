<?php

namespace Braspag\Entities\Payment;

use Braspag\Entities\Cards\Card;
use Braspag\Enum\PaymentTypes;

class DebitCardPayment extends Payment
{
    /**
     * @var Card|null
     */
    public ?Card $DebitCard = null;

    /**
     * @var int
     */
    public int $Installments = 1;

    /**
     * @var string|null
     */
    public ?string $ReturnUrl = null;

    /**
     * @return string
     */
    public function Type(): string
    {
        return PaymentTypes::DEBIT_CARD;
    }
}