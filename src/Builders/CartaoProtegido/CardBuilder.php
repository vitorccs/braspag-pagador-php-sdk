<?php

namespace Braspag\Builders\CartaoProtegido;

use Braspag\Builders\Shared\CardBuilderTrait;
use Braspag\Entities\CartaoProtegido\Card;
use Braspag\Exceptions\BraspagBuilderException;

class CardBuilder
{
    use CardBuilderTrait;

    /**
     * @var Card
     */
    protected Card $card;

    /**
     *
     */
    public function __construct()
    {
        $this->card = new Card();
    }

    /**
     * @return CardBuilder
     */
    public static function create(): self
    {
        return new self();
    }

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
     * @return Card
     */
    public function get(): Card
    {
        return $this->card;
    }
}
