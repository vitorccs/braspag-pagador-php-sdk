<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\CartaoProtegido;

use Braspag\Entities\CartaoProtegido\Card;
use Braspag\Test\Shared\EntityDataProviders;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;

class CardTest extends TestCase
{
    use EntityDataProviders;

    #[DataProvider('validCartaoProtegidoCard')]
    public function test_card_properties(array $properties)
    {
        $creditCard = $this->fillObject(new Card(), $properties);

        foreach ($properties as $property => $value) {
            $this->assertObjectHasProperty($property, $creditCard);
            $this->assertEquals($creditCard->{$property}, $value);
        }
    }
}
