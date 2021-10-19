<?php

namespace Braspag\Helpers;

class Sanitizer
{
    /**
     * @param string|int|null $str
     * @return string
     */
    public static function numeric($str): string
    {
        return preg_replace("/[^0-9]/", '', $str);
    }
}
