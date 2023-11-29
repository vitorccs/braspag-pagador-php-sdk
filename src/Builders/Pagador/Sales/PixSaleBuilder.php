<?php

namespace Braspag\Builders\Pagador\Sales;

use Braspag\Entities\Pagador\Payment\PixPayment;

class PixSaleBuilder extends SaleBuilder
{
    public static function create(string $provider,
                                  ?int   $amount): self
    {
        return new self($provider, $amount);
    }

    public function __construct(string $provider,
                                ?int   $amount)
    {
        $this->payment = new PixPayment($provider, $amount);
    }

    public function setQrCodeExpiration(int $expiration): self
    {
        $this->payment->QrCodeExpiration = $expiration;

        return $this;
    }
}
