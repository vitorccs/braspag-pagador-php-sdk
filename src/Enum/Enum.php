<?php

namespace Braspag\Enum;

use ReflectionClass;

trait Enum
{
    public static function getArray()
    {
        $reflection = new ReflectionClass(get_called_class());

        return $reflection->getConstants();
    }
}
