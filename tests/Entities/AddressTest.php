<?php
declare(strict_types=1);

namespace Braspag\Test\Entities;

use Braspag\Entities\Pagador\Address;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class AddressTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validAddressData
     */
    public function test_properties(array $properties)
    {
        $address = new Address();

        $this->fillObject($address, $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasAttribute($property, $address);
            $this->assertEquals($address->{$property}, $value);
        }
    }
}
