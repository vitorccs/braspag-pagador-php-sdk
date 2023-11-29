<?php

namespace Braspag\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;

abstract class Resource
{
    protected Api $api;

    public function __construct(Client $client)
    {
        $this->api = new Api($client);
    }

    public function setFakeClient(MockHandler $handler): self
    {
        $this->api->setFakeClient($handler);
        return $this;
    }
}
