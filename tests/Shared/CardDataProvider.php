<?php

namespace Braspag\Test\Shared;

trait CardDataProvider
{
    public function validCardNumbersAuto(): array
    {
        $samples = [];

        for ($i = 0; $i <= 100; $i++) {
            $samples[] = FakerHelper::get()->creditCardNumber();
        }

        return [
            '100 valid numbers' => [true, $samples]
        ];
    }

    public function validCardNumbersManual(): array
    {
        $samples = [
            '379072330149966',
            '342172622820417',
            '348996318968237',
            '374646468525074',
            '375513266111326',
            '374351582936865',
            '342668532230571'
        ];

        return [
            count($samples) . ' valid numbers' => [true, $samples]
        ];
    }

    public function invalidCardNumbersAuto(): array
    {
        $samples = [];

        for ($i = 0; $i <= 100; $i++) {
            $samples[] = $this->breakCardNumber(FakerHelper::get()->creditCardNumber());
        }

        return [
            '100 invalid numbers' => [false, $samples]
        ];
    }

    public function invalidCardNumbersManual(): array
    {
        $samples = [
            'abc',
            '',
            '1',
            '111',
            '1111111111111',
            '11111111111111',
            '11111111111111',
            '111111111111111',
            '1111.1111-1111_1111',
            '1111 1111 1111 1111'
        ];

        return [
            count($samples) . ' invalid numbers' => [false, $samples]
        ];
    }

    public function invalidCardSecurityCode(): array
    {
        $samples = [
            'abc',
            '',
            FakerHelper::get()->numberBetween(0, 9),
            FakerHelper::get()->numberBetween(10, 99),
            FakerHelper::get()->numberBetween(10000, 99999)
        ];

        return [
            'invalid' => [false, $samples]
        ];
    }

    public function invalidExpirationDate(): array
    {
        $currYear = intval(date('Y'));

        $samples = [
            'abc',
            '',
            '1',
            '1/2',
            '01/02',
            '/2',
            '1/',
            "13/{$currYear}",
            FakerHelper::get()->date('m/Y', strtotime('now -1 month')),
            FakerHelper::get()->creditCardExpirationDateString(false, 'm/Y'),
        ];

        return [
            'invalid' => [false, $samples]
        ];
    }

    public function invalidCardBrand(): array
    {
        $samples = [
            'abc',
            '',
            FakerHelper::get()->word(),
            FakerHelper::get()->randomDigit()
        ];

        return [
            'invalid' => [false, $samples]
        ];
    }

    public function breakCardNumber(int|string $number): string
    {
        $number = intval($number);
        $lastDigit = substr($number, -1);

        $number = $lastDigit < 9
            ? $number + 1
            : $number - 1;

        return '' . $number;
    }
}
