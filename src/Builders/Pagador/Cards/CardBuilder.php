<?php

namespace Braspag\Builders\Pagador\Cards;

use Braspag\Builders\Shared\CardTrait;
use Braspag\Entities\Pagador\Cards\Card;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CardHelper;

abstract class CardBuilder
{
    use CardTrait;

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
}
