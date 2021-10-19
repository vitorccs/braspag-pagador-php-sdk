<?php

namespace Braspag\Builders\Sales;

use Braspag\Entities\Payment\PixPayment;

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
}
