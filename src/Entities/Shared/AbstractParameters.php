<?php

namespace Braspag\Entities\Shared;

use Braspag\Exceptions\BraspagParameterException;

class AbstractParameters
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
     * The ENV name for toggling Sandbox mode
     */
    const BRASPAG_SANDBOX = 'BRASPAG_SANDBOX';

    /**
     * The Merchant ID
     *
     * @var string|null
     */
    protected ?string $merchantId;

    /**
     * The HTTP timeout
     *
     * @var int|null
     */
    protected ?int $timeout;

    /**
     * The toggle for Sandbox mode
     *
     * @var bool|null
     */
    protected ?bool $sandbox;

    /**
     * The default API timeout
     *
     * @var int
     */
    protected static int $defaultTimeout = 30;

    /**
     * The default API mode
     *
     * @var bool
     */
    protected static bool $defaultSandbox = false;

    /**
     * @return string
     */
    public function getMerchantId(): string
    {
        return $this->merchantId;
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
    protected function setMerchantId(string $merchantId = null): string
    {
        $merchantId = $merchantId ?: getenv(static::BRASPAG_MERCHANT_ID) ?: null;

        if (empty($merchantId)) {
            throw new BraspagParameterException("Missing required parameter '" . static::BRASPAG_MERCHANT_ID . "'");
        }

        return $merchantId;
    }

    /**
     * @param int|null $timeout
     * @throws BraspagParameterException
     */
    protected static function setTimeout(int $timeout = null): int
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
    protected static function setSandbox(bool $sandbox = null): bool
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