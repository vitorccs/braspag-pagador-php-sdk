<?php

namespace Braspag\Entities\Shared;

use Braspag\Exceptions\BraspagParameterException;

class AbstractParameters
{
    /**
     * The ENV name for Merchant ID
     */
    const BRASPAG_MERCHANT_ID = 'BRASPAG_MERCHANT_ID';

    /**
     * The ENV name for toggling Sandbox mode
     */
    const BRASPAG_SANDBOX = 'BRASPAG_SANDBOX';

    /**
     * The ENV name for HTTP Timeout parameter
     */
    const BRASPAG_TIMEOUT = 'BRASPAG_TIMEOUT';

    /**
     * The Merchant ID
     */
    protected ?string $merchantId;

    /**
     * The HTTP timeout
     */
    protected ?int $timeout;

    /**
     * The toggle for Sandbox mode
     */
    protected bool $sandbox;

    /**
     * The default API timeout
     */
    protected static int $defaultTimeout = 30;

    /**
     * The default API mode
     */
    protected static bool $defaultSandbox = false;

    /**
     * The Client Secret
     */
    private ?string $clientSecret;

    /**
     * @throws BraspagParameterException
     */
    public function __construct(string $merchantId = null,
                                bool   $sandbox = null,
                                int    $timeout = null)
    {
        $this->merchantId = $this->setMerchantId($merchantId);
        $this->sandbox = $this->setSandbox($sandbox);
        $this->timeout = $this->setTimeout($timeout);
    }

    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    public function getTimeout(): int
    {
        return $this->timeout;
    }

    public function getSandbox(): bool
    {
        return $this->sandbox;
    }

    public static function getDefaultTimeout(): int
    {
        return self::$defaultTimeout;
    }

    public static function getDefaultSandbox(): bool
    {
        return self::$defaultSandbox;
    }

    /**
     * @throws BraspagParameterException
     */
    private function setMerchantId(string $merchantId = null): string
    {
        $merchantId = $merchantId ?: getenv(static::BRASPAG_MERCHANT_ID) ?: null;

        if (empty($merchantId)) {
            throw new BraspagParameterException("Missing required parameter '" . static::BRASPAG_MERCHANT_ID . "'");
        }

        return $merchantId;
    }

    /**
     * @throws BraspagParameterException
     */
    private static function setTimeout(int $timeout = null): int
    {
        $envValue = getenv(static::BRASPAG_TIMEOUT);

        if (strlen($envValue) && !is_numeric($envValue)) {
            throw new BraspagParameterException("Invalid parameter value for '" . static::BRASPAG_TIMEOUT . "'");
        }

        if (strlen($envValue)) {
            $timeout = intval($envValue);
        }

        if ($timeout === null) {
            $timeout = static::$defaultTimeout;
        }

        return $timeout;
    }

    /**
     * @throws BraspagParameterException
     */
    private static function setSandbox(bool $sandbox = null): bool
    {
        $envValue = strtolower(getenv(static::BRASPAG_SANDBOX));

        if (strlen($envValue) && !in_array($envValue, ['true', 'false'])) {
            throw new BraspagParameterException("Invalid parameter value for '" . static::BRASPAG_SANDBOX . "'");
        }

        if (strlen($envValue)) {
            $sandbox = $envValue === 'true';
        }

        if ($sandbox === null) {
            $sandbox = static::$defaultSandbox;
        }

        return $sandbox;
    }
}
