<?php

namespace Braspag\Entities\Pagador\Payment;

use Braspag\Entities\Pagador\Cards\Card;
use Braspag\Enum\PaymentTypes;

class CreditCardPayment extends Payment
{
    public ?Card $CreditCard = null;

    public int $Installments = 1;

    public ?string $Currency = null;

    public ?string $Country = null;

    public ?string $Interest = null;

    public ?bool $Capture = null;

    public ?bool $Authenticate = null;

    public ?bool $Recurrent = null;

    public ?string $SoftDescriptor = null;

    public bool $DoSplit = false;

    public ?array $Credentials = null;

    public ?array $PaymentFacilitator = null;

    public ?array $ExtraDataCollection = null;

    public function Type(): string
    {
        return PaymentTypes::CREDIT_CARD;
    }
}
