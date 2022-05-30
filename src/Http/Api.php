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
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @param Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $endpoint
     * @param array $query
     * @return object|array|null
     * @throws BraspagProviderException
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    public function get(string $endpoint, array $query = [])
    {
        return $this->request('GET', $endpoint, ['query' => $query]);
    }

    /**
     * @param string $endpoint
     * @param array|object $data
     * @return object|array|null
     * @throws BraspagProviderException
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    public function post(string $endpoint, $data = null)
    {
        return $this->request('POST', $endpoint, ['json' => $data]);
    }

    /**
     * @param string $endpoint
     * @param array|object $data
     * @return object|array|null
     * @throws BraspagProviderException
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    public function put(string $endpoint, $data = null)
    {
        return $this->request('PUT', $endpoint, ['json' => $data]);
    }

    /**
     * @param string $endpoint
     * @param array|object $data
     * @return object|array|null
     * @throws BraspagProviderException
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    public function delete(string $endpoint, $data = null)
    {
        return $this->request('DELETE', $endpoint, ['json' => $data]);
    }

    /**
     * @param MockHandler $handler
     */
    public function setFakeClient(MockHandler $handler): void
    {
        $this->client = FakeClientFactory::create($handler);
    }

    /**
     * @param string $method
     * @param string|null $endpoint
     * @param array $options
     * @return object|array|null
     * @throws BraspagValidationException
     * @throws BraspagRequestException
     * @throws BraspagException
     */
    private function request(string $method,
                             string $endpoint = null,
                             array  $options = [])
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
     * @param ResponseInterface $response
     * @return object|array|null
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    private function response(ResponseInterface $response)
    {
        $content = $response->getBody()->getContents();

        $jsonResponse = json_decode($content);

        $this->checkForErrors($response, $jsonResponse);

        return $jsonResponse;
    }

    /**
     * @param ResponseInterface $response
     * @param object|array|null $jsonResponse
     * @throws BraspagRequestException
     * @throws BraspagValidationException
     */
    private function checkForErrors(ResponseInterface $response, $jsonResponse = null)
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
     * @param object|array|null $jsonResponse
     * @throws BraspagValidationException
     *
     */
    private function checkForValidationException($jsonResponse = null)
    {
        $validationErrors = $jsonResponse->Errors ?? $jsonResponse;

        if (!is_array($validationErrors) || !count($validationErrors)) return;

        $validationError = $validationErrors[0];
        $validationMessage = $validationError->Message ?? null;
        $validationCode = is_numeric($validationError->Code ?? null)
            ? intval($validationError->Code)
            : 0;

        if (empty($validationMessage) && empty($validationCode)) return;

        throw new BraspagValidationException($validationMessage, $validationCode);
    }

    /**
     * Generic Client or Server errors
     *
     * @param ResponseInterface $response
     * @throws BraspagRequestException
     */
    private function checkForRequestException(ResponseInterface $response)
    {
        $code = $response->getStatusCode();
        $reason = $response->getReasonPhrase();

        throw new BraspagRequestException($reason, $code);
    }
}
