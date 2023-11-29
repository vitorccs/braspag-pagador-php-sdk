<?php

namespace Braspag\Builders\Pagador;

use Braspag\Entities\Pagador\Address;
use Braspag\Helpers\ZipCodeHelper;

class AddressBuilder
{
    private Address $address;

    public static function create(): self
    {
        return new self();
    }

    public function __construct()
    {
        $this->address = new Address();
    }

    public function setStreet(string $street): self
    {
        $this->address->Street = $street;

        return $this;
    }

    public function setNumber(?string $number): self
    {
        $this->address->Number = $number;

        return $this;
    }

    public function setComplement(?string $complement): self
    {
        $this->address->Complement = $complement;

        return $this;
    }

    public function setZipCode(string $zipCode): self
    {
        $this->address->ZipCode = ZipCodeHelper::unmask($zipCode);

        return $this;
    }

    public function setCity(string $city): self
    {
        $this->address->City = $city;

        return $this;
    }

    public function setState(string $state): self
    {
        $this->address->State = $state;

        return $this;
    }

    public function setCountry(string $country): self
    {
        $this->address->Country = $country;

        return $this;
    }

    public function setDistrict(?string $District): self
    {
        $this->address->District = $District;

        return $this;
    }

    public function get(): Address
    {
        return $this->address;
    }
}
