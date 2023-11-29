<?php

namespace Braspag\Entities\Pagador;

class Customer
{
    public string $Name;

    public ?string $Identity = null;

    public ?string $IdentityType = null;

    public ?string $Email = null;

    public ?string $Birthdate = null;

    public ?string $IpAddress = null;

    public ?Address $Address = null;

    public ?Address $DeliveryAddress = null;

    public function __construct(string $name)
    {
        $this->Name = $name;
    }
}
