<?php

namespace Braspag\Entities\Pagador\Cards;

abstract class Card
{
    public ?string $CardNumber = null;

    public ?string $Holder = null;

    public ?string $ExpirationDate = null;

    public ?string $SecurityCode = null;

    public ?string $Brand = null;

    public ?bool $SaveCard = null;

    public ?string $Alias = null;

    public ?array $CardOnFile = null;

    public ?string $CardToken = null;

    /**
     * @return string[]
     */
    abstract public function brands(): array;
}
