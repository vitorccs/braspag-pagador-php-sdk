<?php

namespace Braspag\Builders\Pagador\Cards;

use Braspag\Entities\Pagador\Cards\DebitCard;

class DebitCardBuilder extends CardBuilder
{
    /**
     * @return DebitCardBuilder
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
        $this->card = new DebitCard();
    }
}
