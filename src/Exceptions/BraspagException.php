<?php

namespace Braspag\Exceptions;

use Exception;

class BraspagException extends Exception
{
    protected ?string $errorCode;

    public function __construct(?string         $message = null,
                                string|int|null $errorCode = null)
    {
        $message = trim($message ?: 'Undefined error');
        $code = is_numeric($errorCode) ? $errorCode : 0;

        parent::__construct($message, $code);

        $this->errorCode = $errorCode;
    }

    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }
}
