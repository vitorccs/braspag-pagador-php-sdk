<?php

namespace Braspag\Helpers;

class SanitizerHelper
{
    /**
     * Remove any non-numeric chars (0-9)
     */
    public static function numeric(string $str): string
    {
        return preg_replace("/[^0-9]/", '', $str);
    }

    /**
     * Remove any letters (a-z or A-Z) and non-numeric chars (0-9)
     */
    public static function alphanumericOnly(string $value): string
    {
        return preg_replace("/[^0-9A-Z]/i", '', $value);
    }
}
