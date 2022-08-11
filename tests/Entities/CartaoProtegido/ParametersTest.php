<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\CartaoProtegido;

use Braspag\Entities\CartaoProtegido\Parameters;
use Braspag\Exceptions\BraspagParameterException;
use Braspag\Test\Shared\ParametersHelper;
use PHPUnit\Framework\TestCase;

class ParametersTest extends TestCase
{
    protected function setUp(): void
    {
        ParametersHelper::resetEnv();
    }

    /**
     * @dataProvider
     */
    public function test_parameters_by_env()
    {
        $random = ParametersHelper::randomValues();

        ParametersHelper::setEnv($random);

        $parameters = new Parameters();

        $this->assertEquals($parameters->getMerchantId(), getenv(Parameters::BRASPAG_MERCHANT_ID));
        $this->assertEquals($parameters->getClientId(), getenv(Parameters::BRASPAG_CLIENT_ID));
        $this->assertEquals($parameters->getClientSecret(), getenv(Parameters::BRASPAG_CLIENT_SECRET));
    }

    /**
     *
     */
    public function test_parameters_by_instance()
    {
        $random = ParametersHelper::randomValues();

        $parameters = new Parameters(
            $random[Parameters::BRASPAG_MERCHANT_ID],
            $random[Parameters::BRASPAG_CLIENT_ID],
            $random[Parameters::BRASPAG_CLIENT_SECRET]
        );

        $this->assertEquals($parameters->getMerchantId(), $random[Parameters::BRASPAG_MERCHANT_ID]);
        $this->assertEquals($parameters->getClientId(), $random[Parameters::BRASPAG_CLIENT_ID]);
        $this->assertEquals($parameters->getClientSecret(), $random[Parameters::BRASPAG_CLIENT_SECRET]);
    }

    /**
     * @dataProvider missingArguments
     */
    public function test_required_parameters(array $args)
    {
        $this->expectException(BraspagParameterException::class);

        new Parameters(...$args);
    }

    /**
     *
     */
    public function missingArguments(): array
    {
        $random = ParametersHelper::randomValues();

        return [
            'merchant_id' => [
                [
                    null,
                    $random[Parameters::BRASPAG_CLIENT_ID],
                    $random[Parameters::BRASPAG_CLIENT_SECRET]
                ]
            ],
            'client_id' => [
                [
                    $random[Parameters::BRASPAG_MERCHANT_ID],
                    null,
                    $random[Parameters::BRASPAG_CLIENT_SECRET]
                ]
            ],
            'client_secret' => [
                [
                    $random[Parameters::BRASPAG_MERCHANT_ID],
                    $random[Parameters::BRASPAG_CLIENT_ID],
                    null
                ]
            ]
        ];
    }
}
