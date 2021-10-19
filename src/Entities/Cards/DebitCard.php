<?php

namespace Braspag\Entities\Cards;

use Braspag\Enum\DebitCardBrands;

class DebitCard extends Card
{
    /**
     * @return string[]
     */
    public function brands(): array
    {
        return DebitCardBrands::getArray();
    }
}