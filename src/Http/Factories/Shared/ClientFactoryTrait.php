<?php

namespace Braspag\Http\Factories\Shared;

trait ClientFactoryTrait
{
    private static string $sdkVersion = '1.4.0';

    public static function getUserAgent(): string
    {
        $host = $_SERVER['HTTP_HOST'] ?? '';
        return trim("braspag-pagador-php-sdk/" . static::$sdkVersion . "; {$host}");
    }
}
