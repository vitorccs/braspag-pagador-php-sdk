<?php

namespace Braspag\Entities\Pagador;

class Address
{
    /**
     * @var string|null
     */
    public ?string $Street = null;

    /**
     * @var string|null
     */
    public ?string $Number = null;

    /**
     * @var string|null
     */
    public ?string $Complement = null;

    /**
     * @var string|null
     */
    public ?string $ZipCode = null;

    /**
     * @var string|null
     */
    public ?string $City = null;

    /**
     * @var string|null
     */
    public ?string $State = null;

    /**
     * @var string|null
     */
    public ?string $Country = 'BRA';

    /**
     * @var string|null
     */
    public ?string $District = null;
}
