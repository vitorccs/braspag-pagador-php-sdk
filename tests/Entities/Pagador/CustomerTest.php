<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Pagador;

use Braspag\Entities\Pagador\Customer;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CustomerTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validCustomerData
     */
    public function test_properties(array $properties)
    {
        $customer = new Customer($properties['Name']);

        $this->fillObject($customer, $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasProperty($property, $customer);
            $this->assertEquals($customer->{$property}, $value);
        }
    }
}
