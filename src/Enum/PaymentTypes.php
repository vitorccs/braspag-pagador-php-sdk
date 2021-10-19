<?php

namespace Braspag\Enum;

class PaymentTypes
{
    use Enum;

    const PIX = 'Pix';
    const CREDIT_CARD = 'CreditCard';
    const DEBIT_CARD = 'DebitCard';
    const ELECTRONIC_TRANSFER = 'ElectronicTransfer';
    const BANK_SLIP = 'Boleto';
}