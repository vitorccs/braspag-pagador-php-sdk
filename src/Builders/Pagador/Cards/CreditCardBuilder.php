<?php

namespace Braspag\Builders\Pagador\Cards;

use Braspag\Entities\Pagador\Cards\CreditCard;

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
