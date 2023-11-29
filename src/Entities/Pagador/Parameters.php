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
        parent::__construct($merchantId, $sandbox, $timeout);

        $this->merchantKey = $this->setMerchantKey($merchantKey);
    }

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
