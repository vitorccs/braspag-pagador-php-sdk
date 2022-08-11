<?php

namespace Braspag\Builders\Pagador\Sales;

use Braspag\Entities\Pagador\Payment\BoletoPayment;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CpfCnpjHelper;
use Braspag\Helpers\DateTimeHelper;

class BoletoSaleBuilder extends SaleBuilder
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
        $this->payment = new BoletoPayment($provider, $amount);
    }

    /**
     * @param string $number
     * @return $this
     */
    public function setBoletoNumber(string $number): self
    {
        $this->payment->BoletoNumber = $number;

        return $this;
    }

    /**
     * @param string $assignor
     * @return $this
     */
    public function setAssignor(string $assignor): self
    {
        $this->payment->Assignor = $assignor;

        return $this;
    }

    /**
     * @param string $demonstrative
     * @return BoletoSaleBuilder
     */
    public function setDemonstrative(string $demonstrative): self
    {
        $this->payment->Demonstrative = $demonstrative;

        return $this;
    }

    /**
     * @param \DateTime|string $date
     * @return BoletoSaleBuilder
     */
    public function setExpirationDate($date): self
    {
        if ($date instanceof \DateTime) {
            $date = DateTimeHelper::toDateString($date);
        }

        $this->payment->ExpirationDate = $date;

        return $this;
    }

    /**
     * @param string $identification
     * @return BoletoSaleBuilder
     * @throws BraspagBuilderException
     */
    public function setIdentification(string $identification): self
    {
        $identification = $this->validateCnpj($identification);

        $this->payment->Identification = $identification;

        return $this;
    }

    /**
     * @param string $instructions
     * @return BoletoSaleBuilder
     */
    public function setInstructions(string $instructions): self
    {
        $this->payment->Instructions = $instructions;

        return $this;
    }

    /**
     * @param int $days
     * @return BoletoSaleBuilder
     */
    public function setNullifyDays(int $days): self
    {
        $this->payment->NullifyDays = $days;

        return $this;
    }

    /**
     * @param int $days
     * @return BoletoSaleBuilder
     */
    public function setDaysToFine(int $days): self
    {
        $this->payment->DaysToFine = $days;

        return $this;
    }

    /**
     * @param float $rate
     * @return BoletoSaleBuilder
     */
    public function setFineRate(float $rate): self
    {
        $this->payment->FineRate = $rate;

        return $this;
    }

    /**
     * @param int $amount
     * @return BoletoSaleBuilder
     */
    public function setFineAmount(int $amount): self
    {
        $this->payment->FineAmount = $amount;

        return $this;
    }

    /**
     * @param int $days
     * @return BoletoSaleBuilder
     */
    public function setDaysToInterest(int $days): self
    {
        $this->payment->DaysToInterest = $days;

        return $this;
    }

    /**
     * @param float $rate
     * @return BoletoSaleBuilder
     */
    public function setInterestRate(float $rate): self
    {
        $this->payment->InterestRate = $rate;

        return $this;
    }

    /**
     * @param int $amount
     * @return BoletoSaleBuilder
     */
    public function setInterestAmount(int $amount): self
    {
        $this->payment->InterestAmount = $amount;

        return $this;
    }

    /**
     * @param int $amount
     * @return BoletoSaleBuilder
     */
    public function setDiscountAmount(int $amount): self
    {
        $this->payment->DiscountAmount = $amount;

        return $this;
    }

    /**
     * @param \DateTime|string $date
     * @return BoletoSaleBuilder
     */
    public function setDiscountLimitDate($date): self
    {
        if ($date instanceof \DateTime) {
            $date = DateTimeHelper::toDateString($date);
        }

        $this->payment->DiscountLimitDate = $date;

        return $this;
    }

    /**
     * @param float $rate
     * @return BoletoSaleBuilder
     */
    public function setDiscountRate(float $rate): self
    {
        $this->payment->DiscountRate = $rate;

        return $this;
    }

    /**
     * @param string|null $identification
     * @return string|null
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
