<?php

namespace Braspag\Helpers;


class EmailHelper
{
    public static function validate(?string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
