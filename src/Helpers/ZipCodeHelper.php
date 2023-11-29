<?php

namespace Braspag\Helpers;

class ZipCodeHelper
{
    public static function unmask(int|string|null $value): string
    {
        return Sanitizer::numeric($value);
    }
}
