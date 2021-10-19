<?php

namespace Braspag\Entities;

use Braspag\Exceptions\BraspagParameterException;

class Parameters
{
    /**
     * The ENV name for HTTP Timeout parameter
     */
    const BRASPAG_TIMEOUT = 'BRASPAG_TIMEOUT';

    /**
     * The ENV name for Merchant ID
     */
    const BRASPAG_MERCHANT_ID = 'BRASPAG_MERCHANT_ID';

    /**
     * The ENV name for Merchant Key
     */
    const BRASPAG_MERCHANT_KEY = 'BRASPAG_MERCHANT_KEY';

    /**
     * The ENV name for toggling Sandbox mode
     */
    const BRASPAG_SANDBOX = 'BRASPAG_SANDBOX';

    /**
     * The Merchant ID
     *
     * @var string|null
     */
    private ?string $merchantId;

    /**
     * The Merchant Key
     *
     * @var string|null
     */
    private ?string $merchantKey;

    /**
     * The HTTP timeout
     *
     * @var int|null
     */
    private ?int $timeout;

    /**
     * The toggle for Sandbox mode
     *
     * @var bool|null
     */
    private ?bool $sandbox;

    /**
     * The default API timeout
     *
     * @var int
     */
    private static int $defaultTimeout = 30;

    /**
     * The default API mode
     *
     * @var bool
     */
    private static bool $defaultSandbox = false;

    /**
     * @throws BraspagParameterException
     */
    public function __construct(string $merchantId = null,
                                string $merchantKey = null,
                                bool   $sandbox = null,
                                int    $timeout = null)
    {
        $this->merchantId = $this->setMerchantId($merchantId);
        $this->merchantKey = $this->setMerchantKey($merchantKey);
        $this->sandbox = $this->setSandbox($sandbox);
        $this->timeout = $this->setTimeout($timeout);
    }

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
    }

    /**
     * @return string
     */
    public function getMerchantKey(): string
    {
        return $this->merchantKey;
    }

    /**
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * @return bool
     */
    public function getSandbox(): ?bool
    {
        return $this->sandbox;
    }

    /**
     * @return int
     */
    public static function getDefaultTimeout(): int
    {
        return self::$defaultTimeout;
    }

    /**
     * @return bool
     */
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
    private function setMerchantKey(string $merchantKey = null): string
    {
        $merchantKey = $merchantKey ?: getenv(static::BRASPAG_MERCHANT_KEY) ?: null;

        if (empty($merchantKey)) {
            throw new BraspagParameterException("Missing required parameter '" . static::BRASPAG_MERCHANT_KEY . "'");
        }

        return $merchantKey;
    }

    /**
     * @param int|null $timeout
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
     * @param bool|null $sandbox
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