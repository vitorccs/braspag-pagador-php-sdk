<?php

namespace Braspag\Builders\Sales;

use Braspag\Entities\Cards\Card;
use Braspag\Entities\Payment\DebitCardPayment;

class DebitCardSaleBuilder extends SaleBuilder
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
        $this->payment = new DebitCardPayment($provider, $amount);
    }

    /**
     * @param Card $card
     * @return $this
     */
    public function withDebitCard(Card $card): self
    {
        $this->payment->DebitCard = $card;

        return $this;
    }

    /**
     * @param int $installments
     * @return $this
     */
    public function setInstallments(int $installments): self
    {
        $this->payment->Installments = $installments;

        return $this;
    }

    /**
     * @param string $returnUrl
     * @return $this
     */
    public function setReturnUrl(string $returnUrl): self
    {
        $this->payment->ReturnUrl = $returnUrl;

        return $this;
    }
}
