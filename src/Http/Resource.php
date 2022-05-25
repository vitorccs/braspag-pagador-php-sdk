<?php

namespace Braspag\Http;

use Braspag\Entities\Pagador\Parameters;
use GuzzleHttp\Handler\MockHandler;

abstract class Resource
{
    /**
     * @var Api
     */
    protected Api $api;

    /**
     * @param Parameters|null $parameters
     */
    public function __construct(Parameters $parameters = null)
    {
        $this->api = new Api(static::isQueryApi(), $parameters);
    }

    /**
     * @return bool
     */
    public static function isQueryApi(): bool
    {
        return false;
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
