<?php

namespace Braspag\Entities\Pagador\Payment;

use Braspag\Entities\Pagador\Cards\Card;
use Braspag\Enum\PaymentTypes;

class CreditCardPayment extends Payment
{
    /**
     * @var Card|null
     */
    public ?Card $CreditCard = null;

    /**
     * @var int
     */
    public int $Installments = 1;

    /**
     * @var string|null
     */
    public ?string $Currency = null;

    /**
     * @var string|null
     */
    public ?string $Country = null;

    /**
     * @var string|null
     */
    public ?string $Interest = null;

    /**
     * @var bool|null
     */
    public ?bool $Capture = null;

    /**
     * @var bool|null
     */
    public ?bool $Authenticate = null;

    /**
     * @var bool|null
     */
    public ?bool $Recurrent = null;

    /**
     * @var string|null
     */
    public ?string $SoftDescriptor = null;

    /**
     * @var bool
     */
    public bool $DoSplit = false;

    /**
     * @var array|null
     */
    public ?array $Credentials = null;

    /**
     * @var array|null
     */
    public ?array $PaymentFacilitator = null;

    /**
     * @var array|null
     */
    public ?array $ExtraDataCollection = null;

    /**
     * @return string
     */
    public function Type(): string
    {
        return PaymentTypes::CREDIT_CARD;
    }
}
