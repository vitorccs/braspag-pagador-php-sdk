<?php

namespace Braspag\Test\Shared;

use Braspag\Enum\CreditCardBrands;
use Braspag\Enum\DebitCardBrands;
use Braspag\Enum\PaymentTypes;
use Braspag\Enum\Providers;

trait EntityDataProviders
{
    public function fillObject(object $obj, array $properties)
    {
        foreach ($properties as $property => $value) {
            if (property_exists($obj, $property) && !is_array($value)) {
                $obj->{$property} = $value;
            }
        }
    }

    public function validAddressData(): array
    {
        return [
            'valid' => [
                [
                    'Street' => FakerHelper::get()->streetName(),
                    'Number' => FakerHelper::get()->numberBetween(1, 10000),
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

    public function validCreditCard(): array
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

    public function validPixPayment(): array
    {
        return [
            'valid' => [
                [
                    'Type' => PaymentTypes::PIX,
                    'Provider' => Providers::SIMULADO,
                    'Amount' => FakerHelper::get()->numberBetween(10, 100)
                ]
            ]
        ];
    }

    public function validPixSale(): array
    {
        return [
            'valid' => [
                [
                    'MerchantOrderId' => FakerHelper::get()->numberBetween(10000, 99999),
                    'Customer' => [
                        'Name' => FakerHelper::get()->name,
                        'Identity' => FakerHelper::get()->cpf(),
                        'IdentityType' => 'CPF',
                        'Email' => FakerHelper::get()->email(),
                        'Birthdate' => FakerHelper::get()->date(),
                        'IpAddress' => FakerHelper::get()->ipv4()
                    ],
                    'Payment' => $this->validPixPayment()['valid'][0]
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
                    'CreditCard' => $this->validCreditCard()['valid'][0]
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

    public function validCreditCardSale(): array
    {
        return [
            'valid' => [
                [
                    'MerchantOrderId' => FakerHelper::get()->numberBetween(10000, 99999),
                    'Customer' => $this->validCustomerData()['valid'][0],
                    'Payment' => $this->validCreditCardPayment()['valid'][0]
                ]
            ]
        ];
    }
}