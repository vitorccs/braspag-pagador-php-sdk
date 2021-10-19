<?php

namespace Braspag\Helpers;

class CardHelper
{
    /**
     * @param string $cardNumber
     * @return bool
     */
    public static function validateCardNumber(string $cardNumber): bool
    {
        // remove any non-numeric chars
        $numeric = Sanitizer::numeric($cardNumber);

        if (empty($numeric)) return false;

        // Set the string length and parity
        $number_length = strlen($numeric);
        $parity = $number_length % 2;

        // Loop through each digit and do the maths
        $total = 0;
        for ($i = 0; $i < $number_length; $i++) {
            $digit = $numeric[$i];
            // Multiply alternate digits by two
            if ($i % 2 == $parity) {
                $digit *= 2;
                // If the sum is two digits, add them together (in effect)
                if ($digit > 9) {
                    $digit -= 9;
                }
            }
            // Total up the digits
            $total += $digit;
        }

        // If the total mod 10 equals 0, the number is valid
        return $total % 10 == 0;
    }

    /**
     * @param string $expDate
     * @return bool
     */
    public static function validateExpirationDate(string $expDate): bool
    {
        preg_match('/^(\d{2})\/(\d{4})$/', $expDate, $matches);

        $validFormat = count($matches) === 3;

        if (!$validFormat) return false;

        $month = intval($matches[1]);
        $year = intval($matches[2]);

        $validMonth = $month >= 1 && $month <= 12;
        $validYear = $year >= date('Y');

        return $validMonth && $validYear;
    }

    /**
     * @param string $brand
     * @param array $brands
     * @return bool
     */
    public static function validateBrand(string $brand, array $brands): bool
    {
        return in_array($brand, $brands);
    }

    /**
     * @param string|null $code
     * @return bool
     */
    public static function validateSecurityCode(?string $code): bool
    {
        return !empty($code) && preg_match('/^\d{3,4}$/', $code);
    }
}
