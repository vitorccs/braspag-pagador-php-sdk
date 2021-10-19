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
    public function test_properties(array $properties)
    {
        $instanceAddress = new Address();

        $this->fillObject($instanceAddress, $properties);

        $builderAddress = AddressBuilder::create()
            ->setZipCode($properties['ZipCode'])
            ->setStreet($properties['Street'])
            ->setNumber($properties['Number'])
            ->setComplement($properties['Complement'])
            ->setCity($properties['City'])
            ->setState($properties['State'])
            ->setDistrict($properties['District'])
            ->get();

        foreach (array_keys($properties) as $property) {
            $instance = $instanceAddress->{$property};
            $builder = $builderAddress->{$property};

            if ($property === 'ZipCode') {
                $instance = ZipCodeHelper::unmask($instance);
            }

            $this->assertEquals($builder, $instance);
        }
    }
}