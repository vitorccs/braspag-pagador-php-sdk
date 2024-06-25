<?php

namespace Braspag\Test\Shared;

use Braspag\Http\Resource;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class FakeResponseHelper
{
    public static function addMockHandler(Resource                 $resource,
                                          GuzzleException|Response $response): Resource
    {
        $handler = new MockHandler([]);
        $handler->append($response);

        return $resource->setFakeClient($handler);
    }
}
