<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Shared;

use Braspag\Entities\Pagador\Parameters;
use Braspag\Entities\Shared\AbstractParameters;
use Braspag\Test\Shared\ParametersHelper;
use PHPUnit\Framework\TestCase;

class ParametersTest extends TestCase
{
    protected function setUp(): void
    {
        ParametersHelper::resetEnv();
    }

    /**
     *
     */
    public function test_abstract_default_parameters()
    {
        $random = ParametersHelper::randomValues();

        $args = [
            $random[AbstractParameters::BRASPAG_MERCHANT_ID]
        ];

        $parameters = $this->getAbstractParametersMock($args);

        $this->assertEquals($parameters->getTimeout(), Parameters::getDefaultTimeout());
        $this->assertEquals($parameters->getSandbox(), Parameters::getDefaultSandbox());
    }

    /**
     * @dataProvider validEnvSandboxValues
     */
    public function test_abstract_parameters_by_instance(string $sandbox)
    {
        $random = ParametersHelper::randomValues();

        $args = [
            $random[AbstractParameters::BRASPAG_MERCHANT_ID],
            $random[AbstractParameters::BRASPAG_SANDBOX],
            $random[AbstractParameters::BRASPAG_TIMEOUT]
        ];

        $parameters = $this->getAbstractParametersMock($args);

        $this->assertEquals($parameters->getMerchantId(), $random[AbstractParameters::BRASPAG_MERCHANT_ID]);
        $this->assertEquals($parameters->getTimeout(), $random[AbstractParameters::BRASPAG_TIMEOUT]);
        $this->assertEquals($parameters->getSandbox(), $random[AbstractParameters::BRASPAG_SANDBOX]);
    }

    /**
     * @dataProvider validEnvSandboxValues
     */
    public function test_abstract_parameters_by_env(string $sandbox)
    {
        $random = ParametersHelper::randomValues();
        $random[AbstractParameters::BRASPAG_SANDBOX] = $sandbox;

        ParametersHelper::setEnv($random);

        $parameters = $this->getAbstractParametersMock();

        $this->assertEquals($parameters->getMerchantId(), getenv(AbstractParameters::BRASPAG_MERCHANT_ID));
        $this->assertEquals($parameters->getTimeout(), getenv(AbstractParameters::BRASPAG_TIMEOUT));
        $this->assertEquals($parameters->getSandbox(), json_decode(strtolower(getenv(AbstractParameters::BRASPAG_SANDBOX))));
    }

    /**
     * Since Env files has no 'boolean' datatype, we have to evaluate
     * every string representation of a boolean value
     */
    public function validEnvSandboxValues(): array
    {
        return [
            'string "true"' => ['true'],
            'string "false"' => ['false'],
            'string "TRUE"' => ['TRUE'],
            'string "FALSE"' => ['FALSE']
        ];
    }

    /**
     * Create a Mock class which extends the AbstractParameters class
     */
    private function getAbstractParametersMock($args = []): AbstractParameters
    {
        return new class(...$args) extends AbstractParameters {
        };
    }
}
