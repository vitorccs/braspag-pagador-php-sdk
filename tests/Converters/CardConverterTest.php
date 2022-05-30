<?php

namespace Braspag\Test\Converters;

use Braspag\Converters\CardConverter;
use Braspag\Entities\Pagador\Cards\CreditCard;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;

class CardConverterTest extends TestCase
{
    use EntityDataProviders;

    /**
     * @dataProvider validPagadorCreditCard
     */
    public function test_to_cartao_protegido_card(array $pagadorProperties)
    {
        $pagadorCard = new CreditCard();
        $this->fillObject($pagadorCard, $pagadorProperties);

        $cartaoProtegidoCard = CardConverter::toCartaoProtegidoCard($pagadorCard);

        $this->assertEquals($pagadorCard->Alias, $cartaoProtegidoCard->Alias);
        $this->assertEquals($pagadorCard->CardNumber, $cartaoProtegidoCard->Number);
        $this->assertEquals($pagadorCard->ExpirationDate, $cartaoProtegidoCard->ExpirationDate);
        $this->assertEquals($pagadorCard->Holder, $cartaoProtegidoCard->Holder);
        $this->assertEquals($pagadorCard->SecurityCode, $cartaoProtegidoCard->SecurityCode);
    }
}
