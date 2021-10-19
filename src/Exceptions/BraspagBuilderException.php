<?php

namespace Braspag\Exceptions;

class BraspagBuilderException extends BraspagException
{
    public function __construct(string $field)
    {
        parent::__construct("{$field} is invalid");
    }
}