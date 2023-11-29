<?php

namespace Braspag\Http\Factories\Fake;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;

class FakeClientFactory
{
    public static function create(MockHandler $handler): Client
    {
        return new Client([
            'handler' => HandlerStack::create($handler)
        ]);
    }
}
