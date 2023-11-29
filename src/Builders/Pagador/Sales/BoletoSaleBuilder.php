<?php

namespace Braspag\Builders\Pagador\Sales;

use Braspag\Entities\Pagador\Payment\BoletoPayment;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CpfCnpjHelper;
use Braspag\Helpers\DateTimeHelper;

class BoletoSaleBuilder extends SaleBuilder
{
    public static function create(string $provider,
                                  ?int   $amount): self
    {
        return new self($provider, $amount);
    }

    public function __construct(string $provider,
                                ?int   $amount)
    {
        $this->payment = new BoletoPayment($provider, $amount);
    }

    public function setBoletoNumber(string $number): self
    {
        $this->payment->BoletoNumber = $number;

        return $this;
    }

    public function setAssignor(string $assignor): self
    {
        $this->payment->Assignor = $assignor;

        return $this;
    }

    public function setDemonstrative(string $demonstrative): self
    {
        $this->payment->Demonstrative = $demonstrative;

        return $this;
    }

    public function setExpirationDate(\DateTime|string $date): self
    {
        if ($date instanceof \DateTime) {
            $date = DateTimeHelper::toDateString($date);
        }

        $this->payment->ExpirationDate = $date;

        return $this;
    }

    /**
     * @throws BraspagBuilderException
     */
    public function setIdentification(string $identification): self
    {
        $identification = $this->validateCnpj($identification);

        $this->payment->Identification = $identification;

        return $this;
    }

    public function setInstructions(string $instructions): self
    {
        $this->payment->Instructions = $instructions;

        return $this;
    }

    public function setNullifyDays(int $days): self
    {
        $this->payment->NullifyDays = $days;

        return $this;
    }

    public function setDaysToFine(int $days): self
    {
        $this->payment->DaysToFine = $days;

        return $this;
    }

    public function setFineRate(float $rate): self
    {
        $this->payment->FineRate = $rate;

        return $this;
    }

    public function setFineAmount(int $amount): self
    {
        $this->payment->FineAmount = $amount;

        return $this;
    }

    public function setDaysToInterest(int $days): self
    {
        $this->payment->DaysToInterest = $days;

        return $this;
    }

    public function setInterestRate(float $rate): self
    {
        $this->payment->InterestRate = $rate;

        return $this;
    }

    public function setInterestAmount(int $amount): self
    {
        $this->payment->InterestAmount = $amount;

        return $this;
    }

    public function setDiscountAmount(int $amount): self
    {
        $this->payment->DiscountAmount = $amount;

        return $this;
    }

    public function setDiscountLimitDate(\DateTime|string $date): self
    {
        if ($date instanceof \DateTime) {
            $date = DateTimeHelper::toDateString($date);
        }

        $this->payment->DiscountLimitDate = $date;

        return $this;
    }

    public function setDiscountRate(float $rate): self
    {
        $this->payment->DiscountRate = $rate;

        return $this;
    }

    /**
     * @throws BraspagBuilderException
     */
    protected function validateCnpj(?string $identification): ?string
    {
        $identification = CpfCnpjHelper::unmask($identification) ?: null;

        if (!empty($identification) && !CpfCnpjHelper::validateCnpj($identification)) {
            throw new BraspagBuilderException('Identification');
        }

        return $identification;
    }
}
