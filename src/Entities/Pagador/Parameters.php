<?php

namespace Braspag\Entities\Pagador;

use Braspag\Entities\Shared\AbstractParameters;
use Braspag\Exceptions\BraspagParameterException;

class Parameters extends AbstractParameters
{
    /**
     * The ENV name for Merchant Key
     */
    const BRASPAG_MERCHANT_KEY = 'BRASPAG_MERCHANT_KEY';

    /**
     * The Merchant Key
     *
     * @var string|null
     */
    private ?string $merchantKey;

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
    public function getMerchantKey(): string
    {
        return $this->merchantKey;
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
}
