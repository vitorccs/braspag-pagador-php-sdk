<?php

namespace Braspag\Test\Shared;

use Faker\Factory;
use Faker\Generator;

class FakerHelper
{
    /**
     * @var Generator|null
     */
    protected static ?Generator $faker = null;

    /**
     *
     */
    protected static string $fakerLocale = 'pt_BR';

    /**
     * @return Generator
     */
    public static function get(): Generator
    {
        if (is_null(self::$faker)) {
            self::$faker = Factory::create(self::$fakerLocale);
        }

        return self::$faker;
    }
}
