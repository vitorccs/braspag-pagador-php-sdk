<?php

namespace Braspag\Test\Shared;

use Braspag\Entities\Pagador\Parameters as PagadorParameters;
use Braspag\Entities\CartaoProtegido\Parameters as CartaoProtegidoParameters;
use Braspag\Entities\Shared\AbstractParameters;

class ParametersHelper
{
    /**
     * Set env parameters
     */
    public static function setEnv(array $parameters = null): void
    {
        $parameters = $parameters ?: self::randomValues();

        foreach ($parameters as $key => $value) {
            if (is_bool($value)) {
                $value = json_encode($value);
            }
            putenv("$key=$value");
        }
    }

    /**
     * Reset env parameters to empty
     */
    public static function resetEnv(): void
    {
        $parameters = self::randomValues();

        foreach ($parameters as $key => $value) {
            putenv("$key=");
        }
    }

    /**
     * Generate random parameter values
     *
     * @return array
     */
    public static function randomValues(): array
    {
        return [
            AbstractParameters::BRASPAG_MERCHANT_ID => FakerHelper::get()->word(),
            AbstractParameters::BRASPAG_SANDBOX => FakerHelper::get()->boolean,
            AbstractParameters::BRASPAG_TIMEOUT => FakerHelper::get()->numberBetween(0, 60),

            PagadorParameters::BRASPAG_MERCHANT_KEY => FakerHelper::get()->word(),
            CartaoProtegidoParameters::BRASPAG_CLIENT_ID => FakerHelper::get()->word(),

            CartaoProtegidoParameters::BRASPAG_CLIENT_SECRET => FakerHelper::get()->word(),
        ];
    }
}
