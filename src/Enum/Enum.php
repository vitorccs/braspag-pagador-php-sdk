<?php

namespace Braspag\Enum;

use ReflectionClass;

trait Enum
{
    public static function getArray(): array
    {
        $reflection = new ReflectionClass(get_called_class());

        return $reflection->getConstants();
    }
}
