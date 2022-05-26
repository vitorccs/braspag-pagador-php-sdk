<?php

namespace Braspag\Http;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;

abstract class Resource
{
    /**
     * @var Api
     */
    protected Api $api;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->api = new Api($client);
    }

    /**
     * @param MockHandler $handler
     * @return Resource
     */
    public function setFakeClient(MockHandler $handler): self
    {
        $this->api->setFakeClient($handler);
        return $this;
    }
}
