<?php

namespace Braspag\Builders\Shared;

use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CardHelper;

trait CardTrait
{
    /**
     * @param string $value
     * @param string $field
     * @return string
     * @throws BraspagBuilderException
     */
    protected function validateNotEmpty(string $value, string $field): string
    {
        $value = trim($value);

        if (empty($value)) {
            throw new BraspagBuilderException($field);
        }

        return $value;
    }

    /**
     * @param string $cardNumber
     * @return string
     * @throws BraspagBuilderException
     */
    private function validateCardNumber(string $cardNumber): string
    {
        $cardNumber = trim($cardNumber);

        if (!CardHelper::validateCardNumber($cardNumber)) {
            throw new BraspagBuilderException('Card Number');
        }

        return $cardNumber;
    }

    /**
     * @throws BraspagBuilderException
     */
    private function validateExpirationDate(string $expirationDate): string
    {
        $expirationDate = trim($expirationDate);

        if (!CardHelper::validateExpirationDate($expirationDate)) {
            throw new BraspagBuilderException('Card Expiration Date');
        }

        return $expirationDate;
    }

    /**
     * @param string $code
     * @return string
     * @throws BraspagBuilderException
     */
    private function validateSecurityCode(string $code): string
    {
        $code = trim($code) ?: null;

        if (!CardHelper::validateSecurityCode($code)) {
            throw new BraspagBuilderException('Card Security Code');
        }

        return $code;
    }
}
