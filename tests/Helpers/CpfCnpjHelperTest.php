<?php

namespace Braspag\Test\Helpers;

use Braspag\Helpers\CpfCnpjHelper;
use Braspag\Test\Shared\FakerHelper;
use PHPUnit\Framework\TestCase;

class CpfCnpjHelperTest extends TestCase
{
    /**
     * @dataProvider maskedCpfCnpj
     */
    public function test_unmask(string $masked, $unmasked)
    {
        $this->assertEquals(CpfCnpjHelper::unmask($masked), $unmasked);
    }

    /**
     * @dataProvider validCnpjDocuments
     * @dataProvider invalidCnpjDocuments
     */
    public function test_validate_cnpj(array $numbers, bool $valid)
    {
        foreach ($numbers as $number) {
            $validation = CpfCnpjHelper::validateCnpj($number);
            $valid
                ? $this->assertTrue($validation)
                : $this->assertFalse($validation);
        }
    }

    /**
     * @dataProvider validCpfDocuments

     */
    public function test_validate_cpf(array $numbers, bool $valid)
    {
        foreach ($numbers as $number) {
            $validation = CpfCnpjHelper::validateCpf($number);
            $valid
                ? $this->assertTrue($validation)
                : $this->assertFalse($validation);
        }
    }

    /**
     * @dataProvider validCnpjDocuments
     * @dataProvider invalidCnpjDocuments
     * @dataProvider validCpfDocuments
     * @dataProvider invalidCpfDocuments
     */
    public function test_validate_any(array $numbers, bool $valid)
    {
        foreach ($numbers as $number) {
            $validation = CpfCnpjHelper::validateAny($number);
            $valid
                ? $this->assertTrue($validation)
                : $this->assertFalse($validation);
        }
    }

    /**
     * @return \string[][]
     */
    public function maskedCpfCnpj(): array
    {
        return [
            'string_cpf' => ['980.693.820-82', '98069382082'],
            'string_cnpj' => ['51.289.227/0001-30', '51289227000130'],
            'int_cpf' => ['980.693.820-82', 98069382082],
            'int_cnpj' => ['51.289.227/0001-30', 51289227000130]
        ];
    }

    /**
     * @return array[]
     */
    public function validCpfDocuments(): array
    {
        $numbers = [];

        for ($i = 0; $i < 100; $i++) {
            $numbers[] = FakerHelper::get()->cpf();
        }

        $key = count($numbers) . '_valid_cpf';

        return [
            $key => [$numbers, true]
        ];
    }

    /**
     * @return array[]
     */
    public function invalidCpfDocuments(): array
    {
        $numbers = [
            '1',
            '12',
            '123',
            '1234',
            '12345',
            '123456',
            '1234567',
            '12345678',
            '123456789',
            '1234567890',
            '12345678901',
            '11111111111',
            '87774099068'
        ];

        $key = count($numbers) . '_invalid_cpf';

        return [
            $key => [$numbers, false]
        ];
    }

    /**
     * @return array[]
     */
    public function validCnpjDocuments(): array
    {
        $numbers = [];

        for ($i = 0; $i < 100; $i++) {
            $numbers[] = FakerHelper::get()->cnpj();
        }

        $key = count($numbers) . '_valid_cnpj';

        return [
            $key => [$numbers, true]
        ];
    }

    /**
     * @return array[]
     */
    public function invalidCnpjDocuments(): array
    {
        $numbers = [
            '1',
            '12',
            '123',
            '1234',
            '12345',
            '123456',
            '1234567',
            '12345678',
            '123456789',
            '1234567890',
            '12345678901',
            '123456789012',
            '1234567890123',
            '11111111111111',
            '43520728000150'
        ];

        $key = count($numbers) . '_invalid_cnpj';

        return [
            $key => [$numbers, false]
        ];
    }

    /**
     * @param int $length
     * @return string
     */
    public function randomNumber(int $length): string
    {
        $result = '';

        for ($i = 0; $i < $length; $i++) {
            $result .= mt_rand(0, 9);
        }

        echo "$result \n";

        return $result;
    }
}
