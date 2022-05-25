<?php
declare(strict_types=1);

namespace Braspag\Test\Entities;

use Braspag\Entities\Pagador\Parameters;
use Braspag\Test\Shared\ParametersHelper;
use PHPUnit\Framework\TestCase;

class ParametersTest extends TestCase
{
    protected function setUp(): void
    {
        ParametersHelper::resetEnv();
    }

    /**
     * @dataProvider validEnvSandboxValues
     */
    public function test_parameters_by_env(array $random, string $sandbox)
    {
        $random[Parameters::BRASPAG_SANDBOX] = $sandbox;

        ParametersHelper::setEnv($random);
        $parameters = new Parameters();

        $this->assertEquals($parameters->getMerchantId(), getenv(Parameters::BRASPAG_MERCHANT_ID));
        $this->assertEquals($parameters->getMerchantKey(), getenv(Parameters::BRASPAG_MERCHANT_KEY));
        $this->assertEquals($parameters->getTimeout(), getenv(Parameters::BRASPAG_TIMEOUT));
        $this->assertEquals($parameters->getSandbox(), json_decode(strtolower(getenv(Parameters::BRASPAG_SANDBOX))));
    }

    /**
     * @dataProvider validInstanceSandboxValues
     */
    public function test_parameters_by_instance(array $random, bool $sandbox)
    {
        $random[Parameters::BRASPAG_SANDBOX] = $sandbox;

        $parameters = new Parameters(
            $random[Parameters::BRASPAG_MERCHANT_ID],
            $random[Parameters::BRASPAG_MERCHANT_KEY],
            $random[Parameters::BRASPAG_SANDBOX],
            $random[Parameters::BRASPAG_TIMEOUT],
        );

        $this->assertEquals($parameters->getMerchantId(), $random[Parameters::BRASPAG_MERCHANT_ID]);
        $this->assertEquals($parameters->getMerchantKey(), $random[Parameters::BRASPAG_MERCHANT_KEY]);
        $this->assertEquals($parameters->getTimeout(), $random[Parameters::BRASPAG_TIMEOUT]);
        $this->assertEquals($parameters->getSandbox(), $random[Parameters::BRASPAG_SANDBOX]);
    }

    public function test_default_parameters_by_env()
    {
        $random = ParametersHelper::randomValues();
        unset($random[Parameters::BRASPAG_TIMEOUT]);
        unset($random[Parameters::BRASPAG_SANDBOX]);

        ParametersHelper::setEnv($random);
        $parameters = new Parameters();

        $this->assertEquals($parameters->getTimeout(), Parameters::getDefaultTimeout());
        $this->assertEquals($parameters->getSandbox(), Parameters::getDefaultSandbox());
    }

    public function test_default_parameters_by_instance()
    {
        $random = ParametersHelper::randomValues();

        $parameters = new Parameters(
            $random[Parameters::BRASPAG_MERCHANT_ID],
            $random[Parameters::BRASPAG_MERCHANT_KEY]
        );

        $this->assertEquals($parameters->getTimeout(), Parameters::getDefaultTimeout());
        $this->assertEquals($parameters->getSandbox(), Parameters::getDefaultSandbox());
    }

    public function validEnvSandboxValues(): array
    {
        $random = ParametersHelper::randomValues();

        return [
            'string "true"' => [$random, 'true'],
            'string "false"' => [$random, 'false'],
            'string "TRUE"' => [$random, 'TRUE'],
            'string "FALSE"' => [$random, 'FALSE']
        ];
    }

    public function validInstanceSandboxValues(): array
    {
        $random = ParametersHelper::randomValues();

        return [
            'boolean true' => [$random, true],
            'boolean false' => [$random, false]
        ];
    }
}
