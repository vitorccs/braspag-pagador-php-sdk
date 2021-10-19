<?php

namespace Braspag\Entities\Cards;

abstract class Card
{
    /**
     * @var string|null
     */
    public ?string $CardNumber = null;

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
    public ?string $Brand = null;

    /**
     * @var bool|null
     */
    public ?bool $SaveCard = null;

    /**
     * @var string|null
     */
    public ?string $Alias = null;

    /**
     * @var array|null
     */
    public ?array $CardOnFile = null;

    /**
     * @var string|null
     */
    public ?string $CardToken = null;

    /**
     * @return string[]
     */
    abstract public function brands(): array;
}