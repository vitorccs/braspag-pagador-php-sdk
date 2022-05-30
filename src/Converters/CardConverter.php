<?php

namespace Braspag\Converters;

use Braspag\Entities\CartaoProtegido\Card as CartaoProtegidoCard;
use Braspag\Entities\Pagador\Cards\Card as PagadorCard;

class CardConverter
{
    /**
     * @param PagadorCard $pagadorCard
     * @return CartaoProtegidoCard
     */
    public static function toCartaoProtegidoCard(PagadorCard $pagadorCard): CartaoProtegidoCard
    {
        $card = new CartaoProtegidoCard();
        $card->Alias = $pagadorCard->Alias;
        $card->ExpirationDate = $pagadorCard->ExpirationDate;
        $card->SecurityCode = $pagadorCard->SecurityCode;
        $card->Holder = $pagadorCard->Holder;
        $card->Number = $pagadorCard->CardNumber;

        return $card;
    }
}
