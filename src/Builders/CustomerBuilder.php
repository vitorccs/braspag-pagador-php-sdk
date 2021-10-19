<?php

namespace Braspag\Builders;

use Braspag\Entities\Address;
use Braspag\Entities\Customer;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CpfCnpjHelper;
use Braspag\Helpers\EmailHelper;

class CustomerBuilder
{
    /**
     * @var Customer
     */
    private Customer $customer;

    /**
     * @param string $name
     * @return CustomerBuilder
     * @throws BraspagBuilderException
     */
    public static function create(string $name): self
    {
        return new self($name);
    }

    /**
     * @param string $name
     * @throws BraspagBuilderException
     */
    public function __construct(string $name)
    {
        $this->customer = new Customer($name);
        $this->setName($name);
    }

    /**
     * @param string $name
     * @return CustomerBuilder
     * @throws BraspagBuilderException
     */
    public function setName(string $name): self
    {
        $name = $this->validateNotEmpty($name, 'Customer Name');

        $this->customer->Name = $name;

        return $this;
    }

    /**
     * @param string|null $identity
     * @return CustomerBuilder
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
     * @param string|null $email
     * @return CustomerBuilder
     * @throws BraspagBuilderException
     */
    public function setEmail(?string $email): self
    {
        $email = $this->validateEmail($email);

        $this->customer->Email = $email;

        return $this;
    }

    /**
     * @param string|null $birthdate
     * @return CustomerBuilder
     */
    public function setBirthdate(?string $birthdate): self
    {
        $this->customer->Birthdate = $birthdate;

        return $this;
    }

    /**
     * @param string|null $ipAddress
     * @return CustomerBuilder
     */
    public function setIpAddress(?string $ipAddress): self
    {
        $this->customer->IpAddress = $ipAddress;

        return $this;
    }

    /**
     * @param Address|null $address
     * @return CustomerBuilder
     */
    public function setAddress(?Address $address): self
    {
        $this->customer->Address = $address;

        return $this;
    }

    /**
     * @param Address|null $address
     * @return CustomerBuilder
     */
    public function setDeliveryAddress(?Address $address): self
    {
        $this->customer->DeliveryAddress = $address;

        return $this;
    }

    /**
     * @return Customer
     */
    public function get(): Customer
    {
        return $this->customer;
    }

    /**
     * @param string $value
     * @param string $field
     * @return string
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
     * @param string|null $identity
     * @return string|null
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
     * @param string|null $email
     * @return string|null
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