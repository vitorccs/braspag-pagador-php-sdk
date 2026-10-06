<?php

namespace Braspag\Test\Helpers;

use Braspag\Helpers\CpfCnpjHelper;
use Braspag\Test\Shared\FakerHelper;
use PHPUnit\Framework\TestCase;

class CpfCnpjHelperTest extends TestCase
{
    /**
     * @dataProvider validCpfProvider
     */
    public function test_valid_cpf(string $value): void
    {
        $actual = CpfCnpjHelper::validateCpf($value);

        $this->assertTrue($actual);
    }

    /**
     * @dataProvider validCnpjProvider
     */
    public function test_valid_cnpj(string $value): void
    {
        $actual = CpfCnpjHelper::validateCnpj($value);

        $this->assertTrue($actual);
    }

    /**
     * @dataProvider invalidCpfProvider
     * @dataProvider validCnpjProvider
     */
    public function test_invalid_cpf(string $value): void
    {
        $actual = CpfCnpjHelper::validateCpf($value);

        $this->assertFalse($actual);
    }

    /**
     * @dataProvider invalidCnpjProvider
     * @dataProvider validCpfProvider
     */
    public function test_invalid_cnpj(string $value): void
    {
        $actual = CpfCnpjHelper::validateCnpj($value);

        $this->assertFalse($actual);
    }

    /**
     * @dataProvider unmaskProvider
     */
    public function test_unmask(string $value,
                                string $expected): void
    {
        $actual = CpfCnpjHelper::unmask($value);

        $this->assertSame($expected, $actual);
    }

    public static function validCpfProvider(): array
    {
        $faker = FakerHelper::get();

        return [
            'valid masked cpf' => [
                $faker->cpf(true)
            ],
            'valid unmasked cpf' => [
                $faker->cpf(false)
            ]
        ];
    }

    public static function invalidCpfProvider(): array
    {
        return [
            'cpf with valid masked length' => [
                '123.456.789-10'
            ],
            'cpf with valid unmasked length' => [
                '12345678910'
            ],
            'cpf with letters' => [
                '2A2.500.550-05'
            ],
            'cpf below minimum length masked' => [
                '123.456.789-1'
            ],
            'cpf below minimum length unmasked' => [
                '1234567891'
            ],
            'cpf above maximum length masked' => [
                '123.456.789-101'
            ],
            'cpf above maximum length unmasked' => [
                '123456789101'
            ],
            'cpf with only 0' => [
                '00000000000'
            ],
            'cpf with only 1' => [
                '11111111111'
            ],
            'cpf with only 2' => [
                '22222222222'
            ],
            'cpf with only 3' => [
                '33333333333'
            ],
            'cpf with only 4' => [
                '44444444444'
            ],
            'cpf with only 5' => [
                '55555555555'
            ],
            'cpf with only 6' => [
                '66666666666'
            ],
            'cpf with only 7' => [
                '77777777777'
            ],
            'cpf with only 8' => [
                '88888888888'
            ],
            'cpf with only 9' => [
                '99999999999'
            ]
        ];
    }

    public static function validCnpjProvider(): array
    {
        $faker = FakerHelper::get();

        return [
            'valid masked cnpj' => [
                $faker->cnpj(true)
            ],
            'valid unmasked cnpj' => [
                $faker->cnpj(false)
            ],
            'valid masked alphanumeric cnpj' => [
                '12.ABC.345/01DE-35'
            ],
            'valid unmasked alphanumeric cnpj' => [
                '12ABC34501DE35'
            ],
            'valid lowercase alphanumeric cnpj' => [
                '12.abc.345/01de-35'
            ],
            'valid alphanumeric cnpj with letters only on its base' => [
                'ABCDEFGH000195'
            ],
            'valid alphanumeric cnpj with a repeated base' => [
                'AAAAAAAAAAAA45'
            ],
            'valid alphanumeric cnpj (principal)' => [
                '66.Z6M.JJK/0001-53'
            ],
            'valid alphanumeric cnpj (filial 1)' => [
                'H6.96A.6B0/0001-50'
            ],
            'valid alphanumeric cnpj (filial 2)' => [
                'H6.96A.6B0/TK5Y-70'
            ],
            'valid alphanumeric cnpj (filial 3)' => [
                '0C.J0P.D1N/Z3XN-85'
            ],
            'valid alphanumeric cnpj (filial 4)' => [
                '0C.J0P.D1N/E3Y8-00'
            ],
            'valid alphanumeric cnpj (filial 5)' => [
                '0C.J0P.D1N/K0BP-34'
            ]
        ];
    }

    public static function invalidCnpjProvider(): array
    {
        return [
            'cnpj with valid masked length' => [
                '12.345.678/9012-34'
            ],
            'cnpj with valid unmasked length' => [
                '12345678901234'
            ],
            'cnpj below minimum length masked' => [
                '12.345.678/9012-3'
            ],
            'cnpj below minimum length unmasked' => [
                '1234567890123'
            ],
            'cnpj above maximum length masked' => [
                '12.345.678/9012-345'
            ],
            'cnpj above maximum length unmasked' => [
                '123456789012345'
            ],
            'cnpj with only 0' => [
                '00000000000000'
            ],
            'cnpj with only 1' => [
                '11111111111111'
            ],
            'cnpj with only 2' => [
                '22222222222222'
            ],
            'cnpj with only 3' => [
                '33333333333333'
            ],
            'cnpj with only 4' => [
                '44444444444444'
            ],
            'cnpj with only 5' => [
                '55555555555555'
            ],
            'cnpj with only 6' => [
                '66666666666666'
            ],
            'cnpj with only 7' => [
                '77777777777777'
            ],
            'cnpj with only 8' => [
                '88888888888888'
            ],
            'cnpj with only 9' => [
                '99999999999999'
            ],
            'alphanumeric cnpj with invalid first verifying digit' => [
                '12ABC34501DE45'
            ],
            'alphanumeric cnpj with invalid second verifying digit' => [
                '12ABC34501DE34'
            ],
            'alphanumeric cnpj with a letter on its first verifying digit' => [
                '12ABC34501DEA5'
            ],
            'alphanumeric cnpj with a letter on its second verifying digit' => [
                '12ABC34501DE3A'
            ],
            'alphanumeric cnpj below minimum length' => [
                '12ABC34501DE3'
            ],
            'alphanumeric cnpj above maximum length' => [
                '12ABC34501DE355'
            ]
        ];
    }

    public static function unmaskProvider(): array
    {
        return [
            'masked cpf' => [
                '292.500.550-05',
                '29250055005'
            ],
            'cpf typed with a letter' => [
                '292.500.550-0A',
                '2925005500A'
            ],
            'masked numeric cnpj' => [
                '22.196.659/0001-06',
                '22196659000106'
            ],
            'masked alphanumeric cnpj' => [
                '12.ABC.345/01DE-35',
                '12ABC34501DE35'
            ],
            'lowercase alphanumeric cnpj' => [
                '12.abc.345/01de-35',
                '12ABC34501DE35'
            ],
            'unmasked alphanumeric cnpj' => [
                '12ABC34501DE35',
                '12ABC34501DE35'
            ]
        ];
    }
}
