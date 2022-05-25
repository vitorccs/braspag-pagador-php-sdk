<?php

namespace Braspag\Builders\CartaoProtegido;

use Braspag\Builders\Shared\CardTrait;
use Braspag\Entities\CartaoProtegido\Card;
use Braspag\Exceptions\BraspagBuilderException;

class CardBuilder
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

        $this->card->Number = $cardNumber;

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
     * @param string $alias
     * @return $this
     */
    public function setAlias(string $alias): self
    {
        $this->card->Alias = $alias;

        return $this;
    }

    /**
     * @return Card
     */
    public function get(): Card
    {
        return $this->card;
    }
}
