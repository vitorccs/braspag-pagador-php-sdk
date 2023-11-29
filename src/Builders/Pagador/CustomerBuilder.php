<?php

namespace Braspag\Builders\Pagador;

use Braspag\Entities\Pagador\Address;
use Braspag\Entities\Pagador\Customer;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CpfCnpjHelper;
use Braspag\Helpers\EmailHelper;

class CustomerBuilder
{
    private Customer $customer;

    /**
     * @throws BraspagBuilderException
     */
    public static function create(string $name): self
    {
        return new self($name);
    }

    /**
     * @throws BraspagBuilderException
     */
    public function __construct(string $name)
    {
        $this->customer = new Customer($name);
        $this->setName($name);
    }

    /**
     * @throws BraspagBuilderException
     */
    public function setName(string $name): self
    {
        $name = $this->validateNotEmpty($name, 'Customer Name');

        $this->customer->Name = $name;

        return $this;
    }

    /**
     * @throws BraspagBuilderException
     */
    public function setIdentity(?string $identity): self
    {
        $identity = $this->validateCpfCnpj($identity);

        $this->customer->Identity = $identity;
        $this->customer->IdentityType = CpfCnpjHelper::getType($identity);

        return $this;
    }

    /**
     * @throws BraspagBuilderException
     */
    public function setEmail(?string $email): self
    {
        $email = $this->validateEmail($email);

        $this->customer->Email = $email;

        return $this;
    }

    public function setBirthdate(?string $birthdate): self
    {
        $this->customer->Birthdate = $birthdate;

        return $this;
    }

    public function setIpAddress(?string $ipAddress): self
    {
        $this->customer->IpAddress = $ipAddress;

        return $this;
    }

    public function setAddress(?Address $address): self
    {
        $this->customer->Address = $address;

        return $this;
    }

    public function setDeliveryAddress(?Address $address): self
    {
        $this->customer->DeliveryAddress = $address;

        return $this;
    }

    public function get(): Customer
    {
        return $this->customer;
    }

    /**
     * @throws BraspagBuilderException
     */
    protected function validateNotEmpty(string $value, string $field): string
    {
        $value = trim($value);

        if (empty($value)) {
            throw new BraspagBuilderException($field);
        }

        return $value;
    }

    /**
     * @throws BraspagBuilderException
     */
    protected function validateCpfCnpj(?string $identity): ?string
    {
        $identity = CpfCnpjHelper::unmask($identity) ?: null;

        if (!empty($identity) && !CpfCnpjHelper::validateAny($identity)) {
            throw new BraspagBuilderException('Customer Identity');
        }

        return $identity;
    }

    /**
     * @throws BraspagBuilderException
     */
    protected function validateEmail(?string $email): ?string
    {
        $email = trim($email) ?: null;

        if (!empty($email) && !EmailHelper::validate($email)) {
            throw new BraspagBuilderException('Customer Email');
        }

        return $email;
    }
}
