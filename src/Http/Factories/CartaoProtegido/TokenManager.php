<?php

namespace Braspag\Http\Factories\CartaoProtegido;

use Braspag\Entities\CartaoProtegido\Parameters;
use Braspag\Exceptions\BraspagRequestException;
use Braspag\Http\Factories\Fake\FakeClientFactory;
use Braspag\Http\Factories\Shared\ClientFactoryTrait;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;

class TokenManager
{
    use ClientFactoryTrait;

    protected static ?string $token = null;

    protected static int $lastTimestamp = 0;

    protected static int $expiresIn = 0;

    protected static int $timestampOffset = 60;

    /**
     * The API Base URL for authentication
     */
    protected static array $authBaseUrls = [
        'sandbox' => 'https://authsandbox.braspag.com.br/oauth2/token',
        'production' => 'https://auth.braspag.com.br/oauth2/token'
    ];

    protected static string $defaultErrorMessage = 'OAuth2 Authentication failed';

    private Parameters $parameters;

    private Client $client;

    public function __construct(Parameters $parameters)
    {
        $this->parameters = $parameters;
        $this->client = new Client([
            'base_uri' => static::getApiUrl(),
            'timeout' => $this->parameters->getTimeout(),
            'auth' => [
                $this->parameters->getClientId(),
                $this->parameters->getClientSecret()
            ],
            'headers' => [
                'MerchantId' => $this->parameters->getMerchantId(),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent' => self::getUserAgent()
            ]
        ]);
    }

    /**
     * @throws BraspagRequestException
     */
    public function getToken(): string
    {
        if ($this->isExpired()) {
            $this->retrieve();
        }
        return self::$token;
    }

    public function isExpired(): bool
    {
        if (empty(self::$token)) return true;

        $expireTimestamp = self::$lastTimestamp
            + self::$expiresIn
            - self::$timestampOffset;

        return $expireTimestamp <= self::nowTimestamp();
    }

    public function setFakeClient(MockHandler $handler): self
    {
        $this->client = FakeClientFactory::create($handler);
        return $this;
    }

    /**
     * @throws BraspagRequestException
     */
    protected function retrieve(): void
    {
        try {
            $response = $this->client->post('', ['form_params' => [
                'grant_type' => 'client_credentials'
            ]]);

            $contents = $response->getBody()->getContents();

            $this->updateToken($contents);

        } catch (\Throwable $e) {
            throw new BraspagRequestException($e->getMessage(), $e->getCode());
        }
    }

    /**
     * @throws BraspagRequestException
     */
    private function updateToken(string $contents): void
    {
        $jsonResponse = json_decode($contents);
        $accessToken = $jsonResponse->access_token ?? null;

        if (!empty($accessToken)) {
            self::$lastTimestamp = self::nowTimestamp();
            self::$expiresIn = $jsonResponse->expires_in ?? 0;
            self::$token = $accessToken;
            return;
        }

        $errorDescription = $jsonResponse->error_description
            ?? $jsonResponse->error
            ?? self::$defaultErrorMessage;

        throw new BraspagRequestException($errorDescription);
    }

    private static function nowTimestamp(): int
    {
        return (new \DateTime())->getTimestamp();
    }

    private function getApiUrl(): string
    {
        $environment = $this->parameters->getSandbox() ? 'sandbox' : 'production';

        return self::$authBaseUrls[$environment];
    }
}
