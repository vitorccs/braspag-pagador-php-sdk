<?php

namespace Braspag\Builders\Cards;

use Braspag\Entities\Cards\CreditCard;

class CreditCardBuilder extends CardBuilder
{
    /**
     * @return CreditCardBuilder
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     *
     */
    public function __construct()
    {
        $this->card = new CreditCard();
    }
}