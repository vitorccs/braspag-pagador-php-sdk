<?php

namespace Braspag\Http\Factories\CartaoProtegido;

use Braspag\Entities\CartaoProtegido\Parameters;
use Braspag\Http\Factories\Shared\ClientFactoryTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;

class ClientFactory
{
    use ClientFactoryTrait;

    /**
     * The API Base URL
     *
     * @var string[]
     */
    private static array $apiBaseUrls = [
        'sandbox' => 'https://cartaoprotegidoapisandbox.braspag.com.br',
        'production' => 'https://cartaoprotegidoapi.braspag.com.br'
    ];

    /**
     * @param Parameters|null $parameters
     * @return Client
     */
    public static function create(Parameters $parameters = null): Client
    {
        $parameters = $parameters ?: new Parameters();

        $handlerStack = new HandlerStack();
        $handlerStack->setHandler(new CurlHandler());
        $handlerStack->push(BearerMiddleware::handle($parameters));

        return new Client([
            'base_uri' => static::getApiUrl($parameters),
            'timeout' => $parameters->getTimeout(),
            'handler' => $handlerStack,
            'headers' => [
                'MerchantId' => $parameters->getMerchantId(),
                'Content-Type' => 'application/json',
                'User-Agent' => static::getUserAgent()
            ]
        ]);
    }

    /**
     * @param Parameters $parameters
     * @return string
     */
    private static function getApiUrl(Parameters $parameters): string
    {
        $environment = $parameters->getSandbox() ? 'sandbox' : 'production';

        return self::$apiBaseUrls[$environment];
    }
}
