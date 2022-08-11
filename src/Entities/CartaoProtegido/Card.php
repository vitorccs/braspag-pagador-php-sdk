<?php

namespace Braspag\Entities\CartaoProtegido;

class Card
{
    /**
     * @var string|null
     */
    public ?string $Number = null;

    /**
     * @var string|null
     */
    public ?string $Holder = null;

    /**
     * @var string|null
     */
    public ?string $ExpirationDate = null;

    /**
     * @var string|null
     */
    public ?string $SecurityCode = null;

    /**
     * @var string|null
     */
    public ?string $Alias = null;
}
