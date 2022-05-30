<?php
declare(strict_types=1);

namespace Braspag\Test\Entities\Pagador;

use Braspag\Entities\Pagador\Parameters;
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
        $this->assertEquals($parameters->getMerchantKey(), getenv(Parameters::BRASPAG_MERCHANT_KEY));
    }

    /**
     *
     */
    public function test_parameters_by_instance()
    {
        $random = ParametersHelper::randomValues();

        $parameters = new Parameters(
            $random[Parameters::BRASPAG_MERCHANT_ID],
            $random[Parameters::BRASPAG_MERCHANT_KEY],
        );

        $this->assertEquals($parameters->getMerchantId(), $random[Parameters::BRASPAG_MERCHANT_ID]);
        $this->assertEquals($parameters->getMerchantKey(), $random[Parameters::BRASPAG_MERCHANT_KEY]);
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
                    $random[Parameters::BRASPAG_MERCHANT_KEY],
                ]
            ],
            'merchant_key' => [
                [
                    $random[Parameters::BRASPAG_MERCHANT_ID],
                    null
                ]
            ]
        ];
    }
}
