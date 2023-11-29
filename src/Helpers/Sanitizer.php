<?php

namespace Braspag\Helpers;

class Sanitizer
{
    public static function numeric(int|string|null $str): string
    {
        return preg_replace("/[^0-9]/", '', (string) $str);
    }
}
