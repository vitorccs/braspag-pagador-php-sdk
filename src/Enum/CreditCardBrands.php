<?php

namespace Braspag\Enum;

class CreditCardBrands
{
    use Enum;

    const string VISA = 'Visa';
    const string MASTERCARD = 'Master';
    const string AMEX = 'Amex';
    const string ELO = 'Elo';
    const string AURA = 'Aura';
    const string JCB = 'JCB';
    const string DINERS = 'Diners';
    const string DISCOVER = 'Discover';
    const string HIPERCARD = 'Hipercard';
}
