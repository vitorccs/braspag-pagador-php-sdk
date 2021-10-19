<?php
declare(strict_types=1);

namespace Braspag\Test\Exceptions;

use Braspag\Entities\Parameters;
use Braspag\Exceptions\BraspagParameterException;
use Braspag\Test\Shared\ParametersHelper;
use PHPUnit\Framework\TestCase;

class BraspagParameterExceptionTest extends TestCase
{
    public function setUp(): void
    {
        ParametersHelper::resetEnv();
    }

    /**
     * @dataProvider emptyMerchantId
     */
    public function test_invalid_merchant_id_by_env(array $random, $merchantId)
    {
        $this->expectException(BraspagParameterException::class);
        $this->expectExceptionMessage("Missing required parameter 'BRASPAG_MERCHANT_ID'");

        $random[Parameters::BRASPAG_MERCHANT_ID] = $merchantId;

        ParametersHelper::setEnv($random);
        new Parameters();
    }

    /**
     * @dataProvider emptyMerchantId
     */
    public function test_invalid_merchant_id_by_instance(array $random, $merchantId)
    {
        $this->expectException(BraspagParameterException::class);
        $this->expectExceptionMessage("Missing required parameter 'BRASPAG_MERCHANT_ID'");

        $random[Parameters::BRASPAG_MERCHANT_ID] = $merchantId;

        new Parameters(
            $random[Parameters::BRASPAG_MERCHANT_ID],
            $random[Parameters::BRASPAG_MERCHANT_KEY],
            $random[Parameters::BRASPAG_SANDBOX],
            $random[Parameters::BRASPAG_TIMEOUT],
        );
    }

    /**
     * @dataProvider emptyMerchantKey
     */
    public function test_invalid_merchant_key_by_env(array $random, $merchantKey)
    {
        $this->expectException(BraspagParameterException::class);
        $this->expectExceptionMessage("Missing required parameter 'BRASPAG_MERCHANT_KEY'");

        $random[Parameters::BRASPAG_MERCHANT_KEY] = $merchantKey;

        ParametersHelper::setEnv($random);
        new Parameters();
    }

    /**
     * @dataProvider emptyMerchantKey
     */
    public function test_invalid_merchant_key_by_instance(array $random, $merchantKey)
    {
        $this->expectException(BraspagParameterException::class);
        $this->expectExceptionMessage("Missing required parameter 'BRASPAG_MERCHANT_KEY'");

        $random[Parameters::BRASPAG_MERCHANT_KEY] = $merchantKey;

        new Parameters(
            $random[Parameters::BRASPAG_MERCHANT_ID],
            $random[Parameters::BRASPAG_MERCHANT_KEY],
            $random[Parameters::BRASPAG_SANDBOX],
            $random[Parameters::BRASPAG_TIMEOUT],
        );
    }

    /**
     * @dataProvider invalidSandboxValues
     */
    public function test_invalid_sandbox_by_env(array $random, $sandbox)
    {
        $this->expectException(BraspagParameterException::class);
        $this->expectExceptionMessage("Invalid parameter value for 'BRASPAG_SANDBOX'");

        $random[Parameters::BRASPAG_SANDBOX] = $sandbox;

        ParametersHelper::setEnv($random);
        new Parameters();
    }

    /**
     * @dataProvider invalidTimeoutValues
     */
    public function test_invalid_merchant_timeout_by_env(array $random, $timeout)
    {
        $this->expectException(BraspagParameterException::class);
        $this->expectExceptionMessage("Invalid parameter value for 'BRASPAG_TIMEOUT'");

        $random[Parameters::BRASPAG_TIMEOUT] = $timeout;

        ParametersHelper::setEnv($random);
        new Parameters();
    }

    public function emptyMerchantId(): array
    {
        $random = ParametersHelper::randomValues();

        return [
            'empty' => [$random, '']
        ];
    }

    public function emptyMerchantKey(): array
    {
        $random = ParametersHelper::randomValues();

        return [
            'empty' => [$random, '']
        ];
    }

    public function invalidSandboxValues(): array
    {
        $random = ParametersHelper::randomValues();

        return [
            'string "0"' => [$random, '0'],
            'string "1"' => [$random, '1'],
            'string "y"' => [$random, 'y'],
            'string "n"' => [$random, 'n']
        ];
    }

    public function invalidTimeoutValues(): array
    {
        $random = ParametersHelper::randomValues();

        return [
            'string "letters"' => [$random, 'ab'],
            'string "alpha"' => [$random, 'a1']
        ];
    }
}