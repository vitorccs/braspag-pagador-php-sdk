<?php

namespace Braspag\Entities\Pagador\Payment;

abstract class Payment
{
    public ?string $Type;

    public ?string $Provider;

    public ?int $Amount;

    public function __construct(string $provider, ?int $amount)
    {
        $this->Type = $this->Type();
        $this->Provider = $provider;
        $this->Amount = $amount;
    }

    abstract public function Type(): string;
}
