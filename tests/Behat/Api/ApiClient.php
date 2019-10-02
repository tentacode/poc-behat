<?php

declare(strict_types=1);

namespace Tests\Behat\Api;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Client;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

use function Safe\json_decode;

final class ApiClient
{
    /** @var Client */
    private $client;

    /** @var Response|null */
    private static $lastResponse;

    /** @var array */
    private $headers = ['Content_Type' => 'application/json'];

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public static function getLastResponse(): Response
    {
        if (self::$lastResponse === null) {
            throw new \RuntimeException('API did not send any response.');
        }

        return self::$lastResponse;
    }

    public function setHeader(string $key, string $value): void
    {
        $this->headers[$key] = $value;
    }

    public function request(string $endpointUrl, string $method, string $body = null): void
    {
        $endpointUrl = sprintf(
            '%s/%s',
            '/api',
            ltrim($endpointUrl, '/')
        );

        $parameters = [];
        if ($body !== null) {
            $parameters = json_decode($body, true);
        }

        $serverParameters = [];
        foreach ($this->headers as $key => $value) {
            $serverParameters['HTTP_'.strtoupper($key)] = $value;
        }

        try {
            $this->client->request(
                $method,
                $endpointUrl,
                $parameters,
                [],
                $serverParameters
            );
        } catch (AccessDeniedHttpException $e) {
            self::$lastResponse = new Response(
                $e->getMessage(),
                Response::HTTP_FORBIDDEN
            );

            return;
        }

        self::$lastResponse = $this->client->getResponse();
    }
}
