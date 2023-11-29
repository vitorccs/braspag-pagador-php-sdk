<?php

namespace Braspag\Entities\Pagador;

class Address
{
    public ?string $Street = null;

    public ?string $Number = null;

    public ?string $Complement = null;

    public ?string $ZipCode = null;

    public ?string $City = null;

    public ?string $State = null;

    public ?string $Country = 'BRA';

    public ?string $District = null;
}
