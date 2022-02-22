<?php

namespace Braspag\Test\Builders;

use Braspag\Builders\AddressBuilder;
use Braspag\Entities\Address;
use Braspag\Helpers\ZipCodeHelper;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class AddressBuilderTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validAddressData
     */
    public function test_create_address(array $properties)
    {
        $address = AddressBuilder::create()
            ->setZipCode($properties['ZipCode'])
            ->setStreet($properties['Street'])
            ->setNumber($properties['Number'])
            ->setComplement($properties['Complement'])
            ->setCity($properties['City'])
            ->setState($properties['State'])
            ->setDistrict($properties['District'])
            ->get();

        $objAddress = $this->fillObject(
            new Address(),
            $properties
        );
        $objAddress->ZipCode = ZipCodeHelper::unmask($objAddress->ZipCode);

        $this->assertEquals($address, $objAddress);
    }
}
