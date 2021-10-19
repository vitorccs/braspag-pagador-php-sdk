<?php

namespace Braspag\Exceptions;

class BraspagProviderException extends BraspagException
{
    /**
     * @var object
     */
    private object $responseData;

    /**
     * @param string|null $message
     * @param object $responseData
     */
    public function __construct(?string $message, object $responseData)
    {
        $this->responseData = $responseData;

        parent::__construct($message, 0);
    }

    /**
     * @return object
     */
    public function getResponseData(): object
    {
        return $this->responseData;
    }
}