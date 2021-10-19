<?php

namespace Braspag\Builders\Sales;

use Braspag\Entities\Cards\Card;
use Braspag\Entities\Payment\CreditCardPayment;

class CreditCardSaleBuilder extends SaleBuilder
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
        $this->payment = new CreditCardPayment($provider, $amount);
    }

    /**
     * @param Card $creditCard
     * @return $this
     */
    public function withCreditCard(Card $creditCard): self
    {
        $this->payment->CreditCard = $creditCard;

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

    public function setCurrency(string $currency): self
    {
        $this->payment->Currency = $currency;

        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->payment->Country = $country;

        return $this;
    }

    public function setInterest(string $interest): self
    {
        $this->payment->Interest = $interest;

        return $this;
    }

    public function setCapture(bool $capture): self
    {
        $this->payment->Capture = $capture;

        return $this;
    }

    public function setAuthenticate(bool $authenticate): self
    {
        $this->payment->Authenticate = $authenticate;

        return $this;
    }

    public function setRecurrent(bool $recurrent): self
    {
        $this->payment->Recurrent = $recurrent;

        return $this;
    }

    public function setSoftDescriptor(string $softDescriptor): self
    {
        $this->payment->SoftDescriptor = $softDescriptor;

        return $this;
    }

    public function setDoSplit(bool $doSplit): self
    {
        $this->payment->DoSplit = $doSplit;

        return $this;
    }

    public function setCredentials(array $credentials): self
    {
        $this->payment->Credentials = $credentials;

        return $this;
    }

    public function setPaymentFacilitator(array $paymentFacilitator): self
    {
        $this->payment->PaymentFacilitator = $paymentFacilitator;

        return $this;
    }

    public function setExtraDataCollection(array $extraDataCollection): self
    {
        $this->payment->ExtraDataCollection = $extraDataCollection;

        return $this;
    }
}
