<?php

namespace Braspag\Builders\Pagador\Cards;

use Braspag\Builders\Shared\CardBuilderTrait;
use Braspag\Entities\Pagador\Cards\Card;
use Braspag\Exceptions\BraspagBuilderException;
use Braspag\Helpers\CardHelper;

abstract class CardBuilder
{
    use CardBuilderTrait;

    /**
     * @var Card
     */
    protected Card $card;

    /**
     * @throws BraspagBuilderException
     */
    public function setCardNumber(string $cardNumber): self
    {
        $cardNumber = $this->validateCardNumber($cardNumber);

        $this->card->CardNumber = $cardNumber;

        return $this;
    }

    /**
     * @param string $brand
     * @return $this
     * @throws BraspagBuilderException
     */
    public function setBrand(string $brand): self
    {
        $brand = $this->validateBrand($brand);

        $this->card->Brand = $brand;

        return $this;
    }

    /**
     * @param bool $save
     * @return $this
     */
    public function setSaveCard(bool $save): self
    {
        $this->card->SaveCard = $save;

        return $this;
    }

    /**
     * @param array $cardOnFile
     * @return $this
     */
    public function setCardOnFile(array $cardOnFile): self
    {
        $this->card->CardOnFile = $cardOnFile;

        return $this;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setCardToken(string $token): self
    {
        $this->card->CardToken = $token;

        return $this;
    }

    /**
     * @return Card
     */
    public function get(): Card
    {
        return $this->card;
    }

    /**
     * @param string $brand
     * @return string
     * @throws BraspagBuilderException
     */
    private function validateBrand(string $brand): string
    {
        $brand = trim($brand);

        if (!CardHelper::validateBrand($brand, $this->card->brands())) {
            throw new BraspagBuilderException('Card Brand');
        }

        return $brand;
    }
}
