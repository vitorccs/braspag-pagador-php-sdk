<?php

namespace Braspag\Helpers;


class ZipCodeHelper
{
    /**
     * @param string|int|null $value
     * @return string|null
     */
    public static function unmask($value = null): string
    {
        return Sanitizer::numeric($value);
    }
}
