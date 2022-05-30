<?php

namespace Braspag;

use Braspag\Converters\CardConverter;
use Braspag\Entities\CartaoProtegido\Card as CartaoProtegidoCard;
use Braspag\Entities\CartaoProtegido\Parameters;
use Braspag\Entities\Pagador\Cards\Card as PagadorCard;
use Braspag\Exceptions\BraspagProviderException;
use Braspag\Http\Factories\CartaoProtegido\ClientFactory;
use Braspag\Http\Resource;

class CardService extends Resource
{
    /**
     * @param Parameters|null $parameters
     */
    public function __construct(?Parameters $parameters = null)
    {
        $client = ClientFactory::create($parameters);

        parent::__construct($client);
    }

    /**
     * @param PagadorCard|CartaoProtegidoCard|object|array $data
     * @return object|null
     * @throws BraspagProviderException
     * @throws Exceptions\BraspagException
     * @throws Exceptions\BraspagRequestException
     * @throws Exceptions\BraspagValidationException
     */
    public function createToken($data): ?object
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
     * @param string $token
     * @return object|null
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
     * @param string $alias
     * @return object|null
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
     * @param string $token
     * @return object|null
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
     * @param string $token
     * @return object|null
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
     * @param string $token
     * @return object|null
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
