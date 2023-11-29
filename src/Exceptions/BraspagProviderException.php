<?php

namespace Braspag\Exceptions;

class BraspagProviderException extends BraspagException
{
    private object $responseData;

    public function __construct(?string $message,
                                object  $responseData)
    {
        $this->responseData = $responseData;

        parent::__construct($message);
    }

    public function getResponseData(): object
    {
        return $this->responseData;
    }
}
