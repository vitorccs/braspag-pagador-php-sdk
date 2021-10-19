<?php

namespace Braspag\Test;

use Braspag\Http\Resource;
use Braspag\Test\Shared\ParametersHelper;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;

abstract class BaseTest extends TestCase
{
    protected Resource $fakeResource;

    abstract public function resource(): Resource;

    /**
     * Run once before tests
     */
    public function setUp(): void
    {
        ParametersHelper::setEnv();
    }

    public function getFakeResource(Response $response): Resource
    {
        $handler = new MockHandler([]);
        $handler->append($response);

        return $this->resource()
            ->setFakeClient($handler);
    }
}
