<?php

namespace Braspag\Entities\CartaoProtegido;

class Card
{
    public ?string $Number = null;

    public ?string $Holder = null;

    public ?string $ExpirationDate = null;

    public ?string $SecurityCode = null;

    public ?string $Alias = null;
}
