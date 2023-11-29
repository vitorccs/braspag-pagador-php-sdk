<?php

namespace Braspag\Http;

use Braspag\Exceptions\BraspagException;
use Braspag\Exceptions\BraspagProviderException;
use Braspag\Exceptions\BraspagRequestException;
use Braspag\Exceptions\BraspagValidationException;
use Braspag\Http\Factories\Fake\FakeClientFactory;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use Psr\Http\Message\ResponseInterface;

class Api
{
    protected Client $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @throws BraspagProviderException
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    public function get(string       $endpoint,
                        array|object $query = []): object|array|null
    {
        return $this->request('GET', $endpoint, ['query' => $query]);
    }

    /**
     * @throws BraspagProviderException
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    public function post(string       $endpoint,
                         array|object $data = null): object|array|null
    {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    /**
     * @throws BraspagProviderException
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    public function put(string       $endpoint,
                        array|object $data = null): object|array|null
    {
        return $this->request('PUT', $endpoint, ['json' => $data]);
    }

    /**
     * @throws BraspagException
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    public function delete(string       $endpoint,
                           array|object $data = null): object|array|null
    {
        return $this->request('DELETE', $endpoint, ['json' => $data]);
    }

    public function setFakeClient(MockHandler $handler): void
    {
        $this->client = FakeClientFactory::create($handler);
    }

    /**
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    private function request(string  $method,
                             ?string $endpoint = null,
                             array   $options = []): object|array|null
    {
        try {
            $response = $this->client->request($method, $endpoint, $options);
        } catch (RequestException $e) {
            if (!$e->hasResponse()) {
                throw new BraspagRequestException($e->getMessage());
            }

            $response = $e->getResponse();
        } catch (GuzzleException $e) {
            throw new BraspagRequestException($e->getMessage());
        }

        return $this->response($response);
    }

    /**
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    private function response(ResponseInterface $response): object|array|null
    {
        $content = $response->getBody()->getContents();

        $jsonResponse = json_decode($content);

        $this->checkForErrors($response, $jsonResponse);

        return $jsonResponse;
    }

    /**
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    private function checkForErrors(ResponseInterface $response,
                                    object|array|null $jsonResponse): void
    {
        $code = $response->getStatusCode();
        $statusClass = (int)($code / 100);

        if ($statusClass === 4 || $statusClass === 5) {
            $this->checkForValidationException($jsonResponse);
            $this->checkForRequestException($response);
        }
    }

    /**
     * Check for API Pagador Validation errors
     *
     * API Pagador format:
     * [{ "Code": int, "Message": string }]
     *
     * API Cartao Protegido format:
     * { "Errors": [{ "Code": int, "Message": string }] }
     *
     * @throws BraspagValidationException
     *
     */
    private function checkForValidationException(object|array|null $jsonResponse): void
    {
        $validationErrors = $jsonResponse->Errors ?? $jsonResponse;

        if (!is_array($validationErrors) || !count($validationErrors)) return;

        $validationError = $validationErrors[0];
        $validationMessage = $validationError->Message ?? null;
        $validationCode = $validationError->Code ?? null;

        if (empty($validationMessage) && empty($validationCode)) return;

        throw new BraspagValidationException($validationMessage, $validationCode);
    }

    /**
     * Generic Client or Server errors
     *
     * @throws BraspagRequestException
     */
    private function checkForRequestException(ResponseInterface $response)
    {
        $code = $response->getStatusCode();
        $reason = $response->getReasonPhrase();

        throw new BraspagRequestException($reason, $code);
    }
}
