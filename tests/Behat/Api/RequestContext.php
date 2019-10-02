<?php

declare(strict_types=1);

namespace Tests\Behat\Api;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;

final class RequestContext implements Context
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @When I request the :endpointUrl endpoint
     * @When I make a :method request to the :endpointUrl endpoint
     */
    public function iRequestTheEndpoint(
        string $endpointUrl,
        string $method = 'GET'
    ): void {
        $this->client->request($endpointUrl, $method);
    }

    /**
     * @When I request the :endpointUrl endpoint with body:
     * @When I make a :method request to the :endpointUrl endpoint with body:
     */
    public function iRequestTheEndpointWithBody(
        PyStringNode $body,
        string $endpointUrl,
        string $method = 'GET'
    ): void {
        $this->client->request($endpointUrl, $method, $body->getRaw());
    }
}
