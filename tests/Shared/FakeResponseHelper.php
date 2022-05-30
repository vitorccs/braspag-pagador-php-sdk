<?php

namespace Braspag\Test\Shared;

use Braspag\Http\Resource;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;

class FakeResponseHelper
{
    /**
     * @param Resource $resource
     * @param Response|RequestException $response
     * @return Resource
     */
    public static function addMockHandler(Resource $resource, $response): Resource
    {
        $handler = new MockHandler([]);
        $handler->append($response);

        return $resource->setFakeClient($handler);
    }
}
