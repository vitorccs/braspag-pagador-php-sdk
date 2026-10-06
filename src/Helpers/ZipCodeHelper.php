<?php

namespace Braspag\Helpers;

class ZipCodeHelper
{
    public static function unmask(string $value): string
    {
        return SanitizerHelper::numeric($value);
    }
}
