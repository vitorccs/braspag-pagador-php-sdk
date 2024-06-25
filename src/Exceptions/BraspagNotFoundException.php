<?php

namespace Braspag\Exceptions;

class BraspagNotFoundException extends BraspagRequestException
{
    const HTTP_NOT_FOUND = 404;

    public function __construct()
    {
        parent::__construct('Transaction not found', self::HTTP_NOT_FOUND);
    }
}
