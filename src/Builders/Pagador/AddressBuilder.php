<?php

namespace Braspag\Builders\Pagador;

use Braspag\Entities\Pagador\Address;
use Braspag\Helpers\ZipCodeHelper;

class AddressBuilder
{
    /**
     * @var Address
     */
    private Address $address;

    /**
     * @return AddressBuilder
     */
    public static function create(): self
    {
        return new self();
    }

    /**
     *
     */
    public function __construct()
    {
        $this->address = new Address();
    }

    /**
     * @param string $street
     * @return AddressBuilder
     */
    public function setStreet(string $street): self
    {
        $this->address->Street = $street;

        return $this;
    }

    /**
     * @param string|null $number
     * @return AddressBuilder
     */
    public function setNumber(?string $number): self
    {
        $this->address->Number = $number;

        return $this;
    }

    /**
     * @param string|null $complement
     * @return AddressBuilder
     */
    public function setComplement(?string $complement): self
    {
        $this->address->Complement = $complement;

        return $this;
    }

    /**
     * @param string $zipCode
     * @return AddressBuilder
     */
    public function setZipCode(string $zipCode): self
    {
        $this->address->ZipCode = ZipCodeHelper::unmask($zipCode);

        return $this;
    }

    /**
     * @param string $city
     * @return AddressBuilder
     */
    public function setCity(string $city): self
    {
        $this->address->City = $city;

        return $this;
    }

    /**
     * @param string $state
     * @return AddressBuilder
     */
    public function setState(string $state): self
    {
        $this->address->State = $state;

        return $this;
    }

    /**
     * @param string $country
     * @return AddressBuilder
     */
    public function setCountry(string $country): self
    {
        $this->address->Country = $country;

        return $this;
    }

    /**
     * @param string|null $District
     * @return AddressBuilder
     */
    public function setDistrict(?string $District): self
    {
        $this->address->District = $District;

        return $this;
    }

    /**
     * @return Address
     */
    public function get(): Address
    {
        return $this->address;
    }
}
