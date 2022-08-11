<?php

namespace Braspag\Test;

use Braspag\Http\Resource;
use Braspag\Test\Shared\FakeResponseHelper;
use Braspag\Test\Shared\ParametersHelper;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    /**
     * @var Resource
     */
    protected Resource $fakeResource;

    /**
     * @return Resource
     */
    abstract public function resource(): Resource;

    /**
     * Run once before tests
     */
    public function setUp(): void
    {
        ParametersHelper::setEnv();
    }

    /**
     * @param Response|RequestException $response
     * @return Resource
     */
    public function getFakeResource($response): Resource
    {
        return FakeResponseHelper::addMockHandler($this->resource(), $response);
    }
}
