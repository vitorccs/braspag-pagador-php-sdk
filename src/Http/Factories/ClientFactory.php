<?php

namespace Braspag\Http\Factories;

use Braspag\Entities\Parameters;
use GuzzleHttp\Client;

class ClientFactory
{
    /**
     * The API Base URL for creating transactions
     *
     * @var string[]
     */
    private static array $transactionBaseUrls = [
        'sandbox' => 'https://apisandbox.braspag.com.br',
        'production' => 'https://api.braspag.com.br'
    ];

    /**
     * The API Base URL for querying data
     *
     * @var string[]
     */
    private static array $queryBaseUrls = [
        'sandbox' => 'https://apiquerysandbox.braspag.com.br',
        'production' => 'https://apiquery.braspag.com.br'
    ];

    /**
     * @var string
     */
    private static string $sdkVersion = '0.1.0';

    /**
     * @param bool $apiQuery
     * @param Parameters|null $parameters
     * @return Client
     */
    public static function create(bool $apiQuery, Parameters $parameters = null): Client
    {
        $parameters = $parameters ?: new Parameters();

        $host = $_SERVER['HTTP_HOST'] ?? '';

        return new Client([
            'base_uri' => static::getApiUrl($apiQuery, $parameters),
            'timeout' => $parameters->getTimeout(),
            'headers' => [
                'MerchantId' => $parameters->getMerchantId(),
                'MerchantKey' => $parameters->getMerchantKey(),
                'Content-Type' => 'application/json',
                'User-Agent' => trim("braspag-pagador-php-sdk/" . static::$sdkVersion . "; {$host}")
            ]
        ]);
    }

    /**
     * @param bool $apiQuery
     * @param Parameters $parameters
     * @return string
     */
    private static function getApiUrl(bool $apiQuery, Parameters $parameters): string
    {
        $environment = $parameters->getSandbox() ? 'sandbox' : 'production';

        return $apiQuery
            ? self::$queryBaseUrls[$environment]
            : self::$transactionBaseUrls[$environment];
    }
}
