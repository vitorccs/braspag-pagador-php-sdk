<?php

namespace Braspag\Entities\Payment;

abstract class Payment
{
    /**
     * @var string|null
     */
    public ?string $Type;

    /**
     * @var string|null
     */
    public ?string $Provider;

    /**
     * @var int|null
     */
    public ?int $Amount;

    /**
     * @param string $provider
     * @param int|null $amount
     */
    public function __construct(string $provider, ?int $amount)
    {
        $this->Type = $this->Type();
        $this->Provider = $provider;
        $this->Amount = $amount;
    }

    /**
     * @return string
     */
    abstract public function Type(): string;
}