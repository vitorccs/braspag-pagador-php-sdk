<?php

namespace Braspag\Entities\CartaoProtegido;

use Braspag\Entities\Shared\AbstractParameters;
use Braspag\Exceptions\BraspagParameterException;

class Parameters extends AbstractParameters
{
    /**
     * The ENV name for Merchant Key
     */
    const BRASPAG_CLIENT_ID = 'BRASPAG_CLIENT_ID';

    /**
     * The ENV name for Merchant Key
     */
    const BRASPAG_CLIENT_SECRET = 'BRASPAG_CLIENT_SECRET';

    /**
     * The Client ID
     *
     * @var string|null
     */
    private ?string $clientId;

    /**
     * The Client Secret
     *
     * @var string|null
     */
    private ?string $clientSecret;

    /**
     * @throws BraspagParameterException
     */
    public function __construct(string $merchantId = null,
                                string $clientId = null,
                                string $clientSecret = null,
                                bool   $sandbox = null,
                                int    $timeout = null)
    {
        parent::__construct($merchantId, $sandbox, $timeout);

        $this->clientId = $this->setClientId($clientId);
        $this->clientSecret = $this->setClientSecret($clientSecret);
    }

    /**
     * @return string
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * @return string
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * @throws BraspagParameterException
     */
    private function setClientId(string $clientId = null): string
    {
        $clientId = $clientId ?: getenv(static::BRASPAG_CLIENT_ID) ?: null;

        if (empty($clientId)) {
            throw new BraspagParameterException("Missing required parameter '" . static::BRASPAG_CLIENT_ID . "'");
        }

        return $clientId;
    }

    /**
     * @throws BraspagParameterException
     */
    private function setClientSecret(string $clientSecret = null): string
    {
        $clientSecret = $clientSecret ?: getenv(static::BRASPAG_CLIENT_SECRET) ?: null;

        if (empty($clientSecret)) {
            throw new BraspagParameterException("Missing required parameter '" . static::BRASPAG_CLIENT_SECRET . "'");
        }

        return $clientSecret;
    }
}
