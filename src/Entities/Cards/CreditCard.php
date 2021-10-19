<?php

namespace Braspag\Entities\Cards;

use Braspag\Enum\CreditCardBrands;

class CreditCard extends Card
{
    /**
     * @return string[]
     */
    public function brands(): array
    {
        return CreditCardBrands::getArray();
    }
}