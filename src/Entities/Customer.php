<?php

namespace Braspag\Entities;

class Customer
{
    /**
     * @var string
     */
    public string $Name;

    /**
     * @var string|null
     */
    public ?string $Identity = null;

    /**
     * @var string|null
     */
    public ?string $IdentityType = null;

    /**
     * @var string|null
     */
    public ?string $Email = null;

    /**
     * @var string|null
     */
    public ?string $Birthdate = null;

    /**
     * @var string|null
     */
    public ?string $IpAddress = null;

    /**
     * @var Address|null
     */
    public ?Address $Address = null;

    /**
     * @var Address|null
     */
    public ?Address $DeliveryAddress = null;

    /**
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->Name = $name;
    }
}