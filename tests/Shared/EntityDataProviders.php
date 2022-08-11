<?php

namespace Braspag\Test\Shared;

use Braspag\Enum\CreditCardBrands;
use Braspag\Enum\DebitCardBrands;
use Braspag\Enum\PaymentTypes;
use Braspag\Enum\Providers;

trait EntityDataProviders
{
    /**
     * @param object $obj
     * @param array $properties
     * @return object
     */
    public function fillObject(object $obj, array $properties): object
    {
        foreach ($properties as $property => $value) {
            if (property_exists($obj, $property) && !is_array($value)) {
                $obj->{$property} = $value;
            }
        }
        return $obj;
    }

    // basic entities

    public function validAddressData(): array
    {
        return [
            'valid' => [
                [
                    'Street' => FakerHelper::get()->streetName(),
                    'Number' => FakerHelper::get()->randomNumber(5),
                    'Complement' => FakerHelper::get()->secondaryAddress(),
                    'ZipCode' => FakerHelper::get()->postcode(),
                    'City' => FakerHelper::get()->city(),
                    'State' => FakerHelper::get()->stateAbbr(),
                    'District' => FakerHelper::get()->streetName()
                ]
            ]
        ];
    }

    public function validCustomerData(): array
    {
        return [
            'valid' => [
                [
                    'Name' => FakerHelper::get()->name(),
                    'Identity' => FakerHelper::get()->cpf(),
                    'IdentityType' => 'CPF',
                    'Email' => FakerHelper::get()->email(),
                    'Birthdate' => FakerHelper::get()->date(),
                    'IpAddress' => FakerHelper::get()->ipv4()
                ]
            ]
        ];
    }

    // card data

    public function validPagadorCreditCard(): array
    {
        return [
            'valid' => [
                [
                    'CardNumber' => FakerHelper::get()->creditCardNumber(),
                    'Holder' => FakerHelper::get()->name(),
                    'ExpirationDate' => FakerHelper::get()->creditCardExpirationDateString(true, 'm/Y'),
                    'SecurityCode' => '' . FakerHelper::get()->numberBetween(100, 9999),
                    'Brand' => FakerHelper::get()->randomElement(CreditCardBrands::getArray()),
                    'SaveCard' => FakerHelper::get()->boolean(),
                    'Alias' => FakerHelper::get()->word(),
                    'CardOnFile' => null,
                    'CardToken' => null
                ]
            ]
        ];
    }

    public function validDebitCard(): array
    {
        return [
            'valid' => [
                [
                    'CardNumber' => FakerHelper::get()->creditCardNumber(),
                    'Holder' => FakerHelper::get()->creditCardExpirationDateString(),
                    'ExpirationDate' => FakerHelper::get()->creditCardExpirationDateString(true, 'm/Y'),
                    'SecurityCode' => '' . FakerHelper::get()->numberBetween(100, 9999),
                    'Brand' => FakerHelper::get()->randomElement(DebitCardBrands::getArray()),
                    'SaveCard' => FakerHelper::get()->boolean(),
                    'Alias' => FakerHelper::get()->word(),
                    'CardOnFile' => null,
                    'CardToken' => null
                ]
            ]
        ];
    }

    public function validCartaoProtegidoCard(): array
    {
        return [
            'valid' => [
                [
                    'Number' => FakerHelper::get()->creditCardNumber(),
                    'Holder' => FakerHelper::get()->name(),
                    'ExpirationDate' => FakerHelper::get()->creditCardExpirationDateString(true, 'm/Y'),
                    'SecurityCode' => '' . FakerHelper::get()->numberBetween(100, 9999),
                    'Alias' => FakerHelper::get()->word()
                ]
            ]
        ];
    }

    // payment

    public function validBoletoPayment(): array
    {
        return [
            'valid' => [
                [
                    'Type' => PaymentTypes::BOLETO,
                    'Provider' => Providers::SIMULADO,
                    'Amount' => FakerHelper::get()->randomNumber(),
                    'BoletoNumber' => (string) FakerHelper::get()->randomNumber(8),
                    'Assignor' => FakerHelper::get()->text(200),
                    'Demonstrative' => FakerHelper::get()->text(255),
                    'ExpirationDate' => FakerHelper::get()->date(),
                    'Identification' => FakerHelper::get()->cnpj(false),
                    'Instructions' => FakerHelper::get()->text(450),
                    'NullifyDays' => FakerHelper::get()->randomNumber(2),
                    'DaysToFine' => FakerHelper::get()->randomNumber(2),
                    'FineRate' => FakerHelper::get()->randomFloat(5, 1, 99),
                    'FineAmount' => FakerHelper::get()->randomNumber(3),
                    'DaysToInterest' => FakerHelper::get()->randomNumber(2),
                    'InterestRate' => FakerHelper::get()->randomFloat(5, 1, 99),
                    'InterestAmount' => FakerHelper::get()->randomNumber(3),
                    'DiscountAmount' => FakerHelper::get()->randomNumber(3),
                    'DiscountLimitDate' => FakerHelper::get()->date(),
                    'DiscountRate' => FakerHelper::get()->randomFloat(5, 1, 99),
                ]
            ]
        ];
    }

    public function validCreditCardPayment(): array
    {
        return [
            'valid' => [
                [
                    'Type' => PaymentTypes::CREDIT_CARD,
                    'Provider' => Providers::SIMULADO,
                    'Amount' => FakerHelper::get()->numberBetween(10, 100),
                    'Installments' => FakerHelper::get()->numberBetween(1, 12),
                    'Currency' => 'BR',
                    'Country' => 'BRL',
                    'Interest' => FakerHelper::get()->randomElement(['ByMerchant', 'ByIssuer']),
                    'Capture' => FakerHelper::get()->boolean(),
                    'Authenticate' => FakerHelper::get()->boolean(),
                    'Recurrent' => FakerHelper::get()->boolean(),
                    'SoftDescriptor' => FakerHelper::get()->word(),
                    'DoSplit' => FakerHelper::get()->boolean(),
                    'CreditCard' => $this->validPagadorCreditCard()['valid'][0]
                ]
            ]
        ];
    }

    public function validDebitCardPayment(): array
    {
        return [
            'valid' => [
                [
                    'Type' => PaymentTypes::CREDIT_CARD,
                    'Provider' => Providers::SIMULADO,
                    'Amount' => FakerHelper::get()->numberBetween(10, 100),
                    'Installments' => FakerHelper::get()->numberBetween(1, 12),
                    'ReturnUrl' => FakerHelper::get()->url(),
                    'DebitCard' => $this->validDebitCard()['valid'][0]
                ]
            ]
        ];
    }

    public function validPixPayment(): array
    {
        return [
            'valid' => [
                [
                    'Type' => PaymentTypes::PIX,
                    'Provider' => Providers::SIMULADO,
                    'Amount' => FakerHelper::get()->randomNumber(),
                    'QrCodeExpiration' => FakerHelper::get()->numberBetween(1, 259200),
                ]
            ]
        ];
    }

    // sales

    public function validBoletoSale(): array
    {
        return [
            'valid' => [
                [
                    'MerchantOrderId' => FakerHelper::get()->randomNumber(6),
                    'Customer' => $this->validCustomerData()['valid'][0],
                    'Payment' => $this->validBoletoPayment()['valid'][0]
                ]
            ]
        ];
    }

    public function validCreditCardSale(): array
    {
        return [
            'valid' => [
                [
                    'MerchantOrderId' => FakerHelper::get()->randomNumber(6),
                    'Customer' => $this->validCustomerData()['valid'][0],
                    'Payment' => $this->validCreditCardPayment()['valid'][0]
                ]
            ]
        ];
    }

    public function validPixSale(): array
    {
        return [
            'valid' => [
                [
                    'MerchantOrderId' => FakerHelper::get()->randomNumber(6),
                    'Customer' => $this->validCustomerData()['valid'][0],
                    'Payment' => $this->validPixPayment()['valid'][0]
                ]
            ]
        ];
    }
}
