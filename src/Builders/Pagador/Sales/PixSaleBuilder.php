<?php

namespace Braspag\Builders\Pagador\Sales;

use Braspag\Entities\Pagador\Payment\PixPayment;

class PixSaleBuilder extends SaleBuilder
{
    /**
     * @param string $provider
     * @param int|null $amount
     * @return static
     */
    public static function create(string $provider, ?int $amount): self
    {
        return new self($provider, $amount);
    }

    /**
     * @param string $provider
     * @param int|null $amount
     */
    public function __construct(string $provider, ?int $amount)
    {
        $this->payment = new PixPayment($provider, $amount);
    }

    /**
     * @param int $expiration
     * @return $this
     */
    public function setQrCodeExpiration(int $expiration): self
    {
        $this->payment->QrCodeExpiration = $expiration;

        return $this;
    }
}
