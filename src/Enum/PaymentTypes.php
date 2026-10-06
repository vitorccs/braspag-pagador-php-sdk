<?php

namespace Braspag\Enum;

class PaymentTypes
{
    use Enum;

    const string PIX = 'Pix';
    const string CREDIT_CARD = 'CreditCard';
    const string DEBIT_CARD = 'DebitCard';
    const string ELECTRONIC_TRANSFER = 'ElectronicTransfer';
    const string BOLETO = 'Boleto';
}
