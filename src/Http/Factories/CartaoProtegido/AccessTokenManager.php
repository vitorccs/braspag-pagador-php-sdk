<?php

namespace Braspag\Http\Factories\CartaoProtegido;

use Braspag\Entities\CartaoProtegido\Parameters;
use Braspag\Exceptions\BraspagRequestException;
use Braspag\Http\Factories\Shared\ClientFactoryTrait;
use GuzzleHttp\Client;

class AccessTokenManager
{
    use ClientFactoryTrait;

    /**
     * @var string|null
     */
    protected static ?string $token = null;

    /**
     * @var int
     */
    private static int $lastTimestamp = 0;

    /**
     * @var int
     */
    protected static int $expiresIn = 0;

    /**
     * @var int
     */
    private static int $timestampOffset = 60;

    /**
     * The API Base URL for authentication
     *
     * @var string[]
     */
    private static array $authBaseUrls = [
        'sandbox' => 'https://authsandbox.braspag.com.br/oauth2/token',
        'production' => 'https://auth.braspag.com.br/oauth2/token'
    ];

    /**
     * @var string
     */
    private static string $defaultErrorMessage = 'OAuth2 Authentication failed';

    /**
     * @param Parameters $parameters
     * @return string
     * @throws BraspagRequestException
     */
    public static function get(Parameters $parameters): string
    {
        if (self::isExpired()) {
            self::retrieve($parameters);
        }
        return self::$token;
    }

    /**
     * @return bool
     */
    public static function isExpired(): bool
    {
        if (empty(self::$token)) return true;

        $expireTimestamp = self::$lastTimestamp
            + self::$expiresIn
            - self::$timestampOffset;

        return $expireTimestamp <= self::nowTimestamp();
    }

    /**
     * @param Parameters $parameters
     * @return void
     * @throws BraspagRequestException
     */
    private static function retrieve(Parameters $parameters): void
    {
        try {
            $client = new Client([
                'base_uri' => static::getApiUrl($parameters),
                'timeout' => $parameters->getTimeout(),
                'auth' => [
                    $parameters->getClientId(),
                    $parameters->getClientSecret()
                ],
                'headers' => [
                    'MerchantId' => $parameters->getMerchantId(),
                    'Content-Type' => 'application/x-www-form-urlencoded',
                    'User-Agent' => self::getUserAgent()
                ]
            ]);

            $response = $client->post('', ['form_params' => [
                'grant_type' => 'client_credentials'
            ]]);

            $contents = $response->getBody()->getContents();

            self::updateToken($contents);

        } catch (\Throwable $e) {
            throw new BraspagRequestException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @param string $contents
     * @return void
     * @throws BraspagRequestException
     */
    private static function updateToken(string $contents): void
    {
        $jsonResponse = json_decode($contents);
        $accessToken = $jsonResponse->access_token ?? null;

        if (!empty($accessToken)) {
            self::$lastTimestamp = self::nowTimestamp();
            self::$expiresIn = $jsonResponse->expires_in ?? 0;
            self::$token = $accessToken;
        }

        $errorDescription = $jsonResponse->error_description
            ?? $jsonResponse->error
            ?? self::$defaultErrorMessage;

        throw new BraspagRequestException($errorDescription);
    }

    /**
     * @return int
     */
    private static function nowTimestamp(): int
    {
        return (new \DateTime())->getTimestamp();
    }

    /**
     * @param Parameters $parameters
     * @return string
     */
    private static function getApiUrl(Parameters $parameters): string
    {
        $environment = $parameters->getSandbox() ? 'sandbox' : 'production';

        return self::$authBaseUrls[$environment];
    }
}
