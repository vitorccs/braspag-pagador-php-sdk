<?php

namespace Braspag\Builders\Cards;

use Braspag\Entities\Cards\Card;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CardHelper;

abstract class CardBuilder
{
    /**
     * @var Card
     */
    protected Card $card;

    /**
     * @throws BraspagBuilderException
     */
    public function setCardNumber(string $cardNumber): self
    {
        $cardNumber = $this->validateCardNumber($cardNumber);

        $this->card->CardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param string $holder
     * @return $this
     * @throws BraspagBuilderException
     */
    public function setHolder(string $holder): self
    {
        $holder = $this->validateNotEmpty($holder, 'Card Holder');

        $this->card->Holder = $holder;

        return $this;
    }

    /**
     * @param string $expirationDate
     * @return $this
     * @throws BraspagBuilderException
     */
    public function setExpirationDate(string $expirationDate): self
    {
        $expirationDate = $this->validateExpirationDate($expirationDate);

        $this->card->ExpirationDate = $expirationDate;

        return $this;
    }

    /**
     * @param string $brand
     * @return $this
     * @throws BraspagBuilderException
     */
    public function setBrand(string $brand): self
    {
        $brand = $this->validateBrand($brand);

        $this->card->Brand = $brand;

        return $this;
    }

    /**
     * @param string $code
     * @return $this
     * @throws BraspagBuilderException
     */
    public function setSecurityCode(string $code): self
    {
        $code = $this->validateSecurityCode($code);

        $this->card->SecurityCode = $code;

        return $this;
    }

    /**
     * @param bool $save
     * @return $this
     */
    public function setSaveCard(bool $save): self
    {
        $this->card->SaveCard = $save;

        return $this;
    }

    /**
     * @param string $alias
     * @return $this
     */
    public function setAlias(string $alias): self
    {
        $this->card->Alias = $alias;

        return $this;
    }

    /**
     * @param array $cardOnFile
     * @return $this
     */
    public function setCardOnFile(array $cardOnFile): self
    {
        $this->card->CardOnFile = $cardOnFile;

        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setCardToken(string $token): self
    {
        $this->card->CardToken = $token;

        return $this;
    }

    /**
     * @return Card
     */
    public function get(): Card
    {
        return $this->card;
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
     * @param string $cardNumber
     * @return string
     * @throws BraspagBuilderException
     */
    private function validateCardNumber(string $cardNumber): string
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
    private function validateExpirationDate(string $expirationDate): string
    {
        $expirationDate = trim($expirationDate);

        if (!CardHelper::validateExpirationDate($expirationDate)) {
            throw new BraspagBuilderException('Card Expiration Date');
        }

        return $expirationDate;
    }

    /**
     * @param string $brand
     * @return string
     * @throws BraspagBuilderException
     */
    private function validateBrand(string $brand): string
    {
        $brand = trim($brand);

        if (!CardHelper::validateBrand($brand, $this->card->brands())) {
            throw new BraspagBuilderException('Card Brand');
        }

        return $brand;
    }

    /**
     * @param string $code
     * @return string
     * @throws BraspagBuilderException
     */
    private function validateSecurityCode(string $code): string
    {
        $code = trim($code) ?: null;

        if (!CardHelper::validateSecurityCode($code)) {
            throw new BraspagBuilderException('Card Security Code');
        }

        return $code;
    }
}