<?php

namespace Braspag\Exceptions;

use Exception;

class BraspagException extends Exception
{
    /**
     * @param string|null $message
     * @param int $errorCode
     */
    public function __construct(string $message = null, int $errorCode = 0)
    {
        $message = trim($message ?: 'Undefined error');

        parent::__construct($message, $errorCode);
    }
}
