<?php

namespace Braspag;

use Braspag\Converters\CardConverter;
use Braspag\Entities\CartaoProtegido\Card as CartaoProtegidoCard;
use Braspag\Entities\CartaoProtegido\Parameters;
use Braspag\Entities\Pagador\Cards\Card as PagadorCard;
use Braspag\Exceptions\BraspagException;
use Braspag\Exceptions\BraspagProviderException;
use Braspag\Exceptions\BraspagRequestException;
use Braspag\Exceptions\BraspagValidationException;
use Braspag\Http\Factories\CartaoProtegido\ClientFactory;
use Braspag\Http\Resource;

class CardService extends Resource
{
    public function __construct(?Parameters $parameters = null)
    {
        $client = ClientFactory::create($parameters);

        parent::__construct($client);
    }

    /**
     * @throws BraspagProviderException
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    public function createToken(PagadorCard|CartaoProtegidoCard|array $data): ?object
    {
        if ($data instanceof PagadorCard) {
            $data = CardConverter::toCartaoProtegidoCard($data);
        }

        if (is_array($data)) {
            $data = (object) $data;
        }

        return $this->api->post('v1/token', [
            'Alias' => $data->Alias ?? null,
            'Card' => $data
        ]);
    }

    /**
     * @throws BraspagProviderException
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function getCardByToken(string $token): ?object
    {
        return $this->api->get("v1/Token/{$token}");
    }

    /**
     * @throws BraspagProviderException
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function getTokenByAlias(string $alias): ?object
    {
        return $this->api->get("v1/Alias/{$alias}/TokenReference");
    }

    /**
     * @throws BraspagProviderException
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function suspendToken(string $token): ?object
    {
        return $this->api->put("v1/Token/{$token}/suspend");
    }

    /**
     * @throws BraspagProviderException
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function unsuspendToken(string $token): ?object
    {
        return $this->api->put("v1/Token/{$token}/unsuspend");
    }

    /**
     * @throws BraspagProviderException
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function removeToken(string $token): ?object
    {
        return $this->api->delete("v1/Token/{$token}");
    }
}
