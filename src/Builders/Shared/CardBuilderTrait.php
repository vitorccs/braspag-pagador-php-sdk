<?php

namespace Braspag\Builders\Shared;

use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CardHelper;

trait CardBuilderTrait
{
    /**
     * @param string $alias
     * @return self
     */
    public function setAlias(string $alias): self
    {
        $this->card->Alias = $alias;

        return $this;
    }

    /**
     * @param string $expirationDate
     * @return self
     * @throws BraspagBuilderException
     */
    public function setExpirationDate(string $expirationDate): self
    {
        $expirationDate = $this->validateExpirationDate($expirationDate);

        $this->card->ExpirationDate = $expirationDate;

        return $this;
    }

    /**
     * @param string $holder
     * @return self
     * @throws BraspagBuilderException
     */
    public function setHolder(string $holder): self
    {
        $holder = $this->validateNotEmpty($holder, 'Card Holder');

        $this->card->Holder = $holder;

        return $this;
    }

    /**
     * @param string $code
     * @return self
     * @throws BraspagBuilderException
     */
    public function setSecurityCode(string $code): self
    {
        $code = $this->validateSecurityCode($code);

        $this->card->SecurityCode = $code;

        return $this;
    }

    /**
     * @param string $cardNumber
     * @return string
     * @throws BraspagBuilderException
     */
    protected function validateCardNumber(string $cardNumber): string
    {
        $cardNumber = trim($cardNumber);

        if (!CardHelper::validateCardNumber($cardNumber)) {
            throw new BraspagBuilderException('Card Number');
        }

        return $cardNumber;
    }

    /**
     * @throws BraspagBuilderException
     */
    protected function validateExpirationDate(string $expirationDate): string
    {
        $expirationDate = trim($expirationDate);

        if (!CardHelper::validateExpirationDate($expirationDate)) {
            throw new BraspagBuilderException('Card Expiration Date');
        }

        return $expirationDate;
    }

    /**
     * @param string $value
     * @param string $field
     * @return string
     * @throws BraspagBuilderException
     */
    protected function validateNotEmpty(string $value, string $field): string
    {
        $value = trim($value);

        if (empty($value)) {
            throw new BraspagBuilderException($field);
        }

        return $value;
    }

    /**
     * @param string $code
     * @return string
     * @throws BraspagBuilderException
     */
    protected function validateSecurityCode(string $code): string
    {
        $code = trim($code) ?: null;

        if (!CardHelper::validateSecurityCode($code)) {
            throw new BraspagBuilderException('Card Security Code');
        }

        return $code;
    }
}
