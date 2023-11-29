<?php

namespace Braspag\Http\Factories\Pagador;

use Braspag\Entities\Pagador\Parameters;
use Braspag\Http\Factories\Shared\ClientFactoryTrait;
use GuzzleHttp\Client;

class ClientFactory
{
    use ClientFactoryTrait;

    /**
     * The API Base URL for creating transactions
     */
    private static array $transactionBaseUrls = [
        'sandbox' => 'https://apisandbox.braspag.com.br',
        'production' => 'https://api.braspag.com.br'
    ];

    /**
     * The API Base URL for querying data
     */
    private static array $queryBaseUrls = [
        'sandbox' => 'https://apiquerysandbox.braspag.com.br',
        'production' => 'https://apiquery.braspag.com.br'
    ];

    public static function create(bool        $isQuery,
                                  ?Parameters $parameters = null): Client
    {
        $parameters = $parameters ?: new Parameters();

        return new Client([
            'base_uri' => static::getApiUrl($isQuery, $parameters),
            'timeout' => $parameters->getTimeout(),
            'headers' => [
                'MerchantId' => $parameters->getMerchantId(),
                'MerchantKey' => $parameters->getMerchantKey(),
                'Content-Type' => 'application/json',
                'User-Agent' => static::getUserAgent()
            ]
        ]);
    }

    private static function getApiUrl(bool       $isQuery,
                                      Parameters $parameters): string
    {
        $environment = $parameters->getSandbox() ? 'sandbox' : 'production';

        return $isQuery
            ? self::$queryBaseUrls[$environment]
            : self::$transactionBaseUrls[$environment];
    }
}
