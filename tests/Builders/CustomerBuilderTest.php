<?php

namespace Braspag\Test\Builders;

use Braspag\Builders\CustomerBuilder;
use Braspag\Entities\Customer;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CpfCnpjHelper;
use Braspag\Test\Shared\EntityDataProviders;
use Braspag\Test\Shared\FakerHelper;
use PHPUnit\Framework\TestCase;

class CustomerBuilderTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validCustomerData
     */
    public function test_create_customer(array $properties)
    {
        $customer = CustomerBuilder::create($properties['Name'])
            ->setIdentity($properties['Identity'])
            ->setEmail($properties['Email'])
            ->setBirthdate($properties['Birthdate'])
            ->setIpAddress($properties['IpAddress'])
            ->get();

        $objCustomer = $this->fillObject(
            new Customer($properties['Name']),
            $properties
        );
        $objCustomer->Identity = CpfCnpjHelper::unmask($objCustomer->Identity);

        $this->assertEquals($customer, $objCustomer);
    }

    /**
     * @dataProvider invalidName
     */
    public function test_create_invalid_name(string $name)
    {
        $this->expectException(BraspagBuilderException::class);

        CustomerBuilder::create($name);
    }

    /**
     * @dataProvider invalidEmail
     */
    public function test_create_invalid_email(string $mail)
    {
        $this->expectException(BraspagBuilderException::class);

        $name = $this->validCustomerData()['valid'][0]['Name'];

        CustomerBuilder::create($name)
            ->setEmail($mail);
    }

    /**
     * @dataProvider invalidCpf
     */
    public function test_create_invalid_cpf(string $cpf)
    {
        $this->expectException(BraspagBuilderException::class);

        $name = $this->validCustomerData()['valid'][0]['Name'];

        CustomerBuilder::create($name)
            ->setEmail($cpf);
    }

    /**
     * @dataProvider invalidCnpj
     */
    public function test_create_invalid_cnpj(string $cnpj)
    {
        $this->expectException(BraspagBuilderException::class);

        $name = $this->validCustomerData()['valid'][0]['Name'];

        CustomerBuilder::create($name)
            ->setEmail($cnpj);
    }

    public function invalidName(): array
    {
        return [
            'empty' => ['']
        ];
    }

    public function invalidEmail(): array
    {
        return [
            'test' => ['test'],
            'test@test' => ['test@test'],
            'testtest.com' => ['testtest.com']
        ];
    }

    public function invalidCpf(): array
    {
        $cpf = FakerHelper::get()->cpf(false);
        $lastDigit = substr($cpf, -1);
        $invalidCpf = $lastDigit < 9 ? $cpf + 1 : $cpf - 1;

        return [
            'invalid cpf' => ['000.000.000-00'],
            'invalid cpf digit' => ["$invalidCpf"]
        ];
    }

    public function invalidCnpj(): array
    {
        $cnpj = FakerHelper::get()->cnpj(false);
        $lastDigit = substr($cnpj, -1);
        $invalidCnpj = $lastDigit < 9 ? $cnpj + 1 : $cnpj - 1;

        return [
            'invalid cnpj' => ['00.000.000/0000-00'],
            'invalid cnpj digit' => ["$invalidCnpj"]
        ];
    }
}
