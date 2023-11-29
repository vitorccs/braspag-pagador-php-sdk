<?php

namespace Braspag\Entities\Pagador\Payment;

use Braspag\Enum\PaymentTypes;

class BoletoPayment extends Payment
{
    public ?string $BoletoNumber = null;

    public ?string $Assignor = null;

    public ?string $Demonstrative = null;

    public ?string $ExpirationDate = null;

    public ?string $Identification = null;

    public ?string $Instructions = null;

    public ?int $NullifyDays = null;

    public ?int $DaysToFine = null;

    public ?float $FineRate = null;

    public ?int $FineAmount = null;

    public ?int $DaysToInterest = null;

    public ?float $InterestRate = null;

    public ?int $InterestAmount = null;

    public ?int $DiscountAmount = null;

    public ?string $DiscountLimitDate = null;

    public ?float $DiscountRate = null;

    public function Type(): string
    {
        return PaymentTypes::BOLETO;
    }
}
