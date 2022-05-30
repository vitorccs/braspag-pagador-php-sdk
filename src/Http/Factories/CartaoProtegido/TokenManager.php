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

    /**
     * @var string|null
     */
    protected static ?string $token = null;

    /**
     * @var int
     */
    protected static int $lastTimestamp = 0;

    /**
     * @var int
     */
    protected static int $expiresIn = 0;

    /**
     * @var int
     */
    protected static int $timestampOffset = 60;

    /**
     * The API Base URL for authentication
     *
     * @var string[]
     */
    protected static array $authBaseUrls = [
        'sandbox' => 'https://authsandbox.braspag.com.br/oauth2/token',
        'production' => 'https://auth.braspag.com.br/oauth2/token'
    ];

    /**
     * @var string
     */
    protected static string $defaultErrorMessage = 'OAuth2 Authentication failed';

    /**
     * @var Parameters
     */
    private Parameters $parameters;

    /**
     * @var Client
     */
    private Client $client;

    /**
     * @param Parameters $parameters
     */
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
     * @return string
     * @throws BraspagRequestException
     */
    public function getToken(): string
    {
        if ($this->isExpired()) {
            $this->retrieve();
        }
        return self::$token;
    }

    /**
     * @return bool
     */
    public function isExpired(): bool
    {
        if (empty(self::$token)) return true;

        $expireTimestamp = self::$lastTimestamp
            + self::$expiresIn
            - self::$timestampOffset;

        return $expireTimestamp <= self::nowTimestamp();
    }

    /**
     * @param MockHandler $handler
     * @return TokenManager
     */
    public function setFakeClient(MockHandler $handler): self
    {
        $this->client = FakeClientFactory::create($handler);
        return $this;
    }

    /**
     * @return void
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
     * @param string $contents
     * @return void
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

    /**
     * @return int
     */
    private static function nowTimestamp(): int
    {
        return (new \DateTime())->getTimestamp();
    }

    /**
     * @return string
     */
    private function getApiUrl(): string
    {
        $environment = $this->parameters->getSandbox() ? 'sandbox' : 'production';

        return self::$authBaseUrls[$environment];
    }
}
