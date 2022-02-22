<?php

namespace Braspag\Entities\Payment;

use Braspag\Enum\PaymentTypes;

class BoletoPayment extends Payment
{
    /**
     * @var string|null
     */
    public ?string $BoletoNumber = null;

    /**
     * @var string|null
     */
    public ?string $Assignor = null;

    /**
     * @var string|null
     */
    public ?string $Demonstrative = null;

    /**
     * @var string|null
     */
    public ?string $ExpirationDate = null;

    /**
     * @var string|null
     */
    public ?string $Identification = null;

    /**
     * @var string|null
     */
    public ?string $Instructions = null;

    /**
     * @var int|null
     */
    public ?int $NullifyDays = null;

    /**
     * @var int|null
     */
    public ?int $DaysToFine = null;

    /**
     * @var float|null
     */
    public ?float $FineRate = null;

    /**
     * @var int|null
     */
    public ?int $FineAmount = null;

    /**
     * @var int|null
     */
    public ?int $DaysToInterest = null;

    /**
     * @var float|null
     */
    public ?float $InterestRate = null;

    /**
     * @var int|null
     */
    public ?int $InterestAmount = null;

    /**
     * @var int|null
     */
    public ?int $DiscountAmount = null;

    /**
     * @var string|null
     */
    public ?string $DiscountLimitDate = null;

    /**
     * @var float|null
     */
    public ?float $DiscountRate = null;

    /**
     * @return string
     */
    public function Type(): string
    {
        return PaymentTypes::BOLETO;
    }
}
