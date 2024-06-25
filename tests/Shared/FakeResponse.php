<?php

namespace Braspag\Test\Shared;

use GuzzleHttp\Psr7\Response;

class FakeResponse extends Response
{
    /**
     * @var array|object|null
     */
    private array|null|object $jsonResponse;

    /**
     * @param int $status
     * @param array $headers
     * @param string|null $body
     */
    public function __construct(
        int    $status = 200,
        array  $headers = [],
        string $body = null
    )
    {
        parent::__construct($status, $headers, $body);

        $this->setJsonResponse($body);
    }

    /**
     * @return array|object|null
     */
    public function getJsonResponse()
    {
        return $this->jsonResponse;
    }

    /**
     * @param string|null $body
     */
    private function setJsonResponse(?string $body): void
    {
        $this->jsonResponse = is_string($body) && strlen($body)
            ? json_decode($body)
            : null;
    }
}
