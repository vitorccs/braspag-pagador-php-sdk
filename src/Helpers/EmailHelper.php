<?php

namespace Braspag\Helpers;


class EmailHelper
{
    /**
     * @param string|null $email
     * @return bool
     */
    public static function validate(?string $email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
}
