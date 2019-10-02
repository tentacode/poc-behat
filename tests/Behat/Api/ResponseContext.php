<?php

declare(strict_types=1);

namespace Tests\Behat\Api;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use PHPUnit\Framework\Assert;

final class ResponseContext implements Context
{
    /** @var ApiClient */
    private $client;

    public function __construct(ApiClient $client)
    {
        $this->client = $client;
    }

    /**
     * @Then the response should be successful
     * @Then the response should be a :statusCode successful response
     */
    public function theResponseShouldBeSuccessful(int $statusCode = 200): void
    {

        Assert::assertRegExp('/^2[0-9]{2}$/', (string)$statusCode, 'Expected status code is invalid.');
        Assert::assertEquals(
            $statusCode,
            ApiClient::getLastResponse()->getStatusCode(),
            "Unexpected API response status code."
        );
    }

    /**
     * @Then the response should be a :statusCode error response with message:
     */
    public function theResponseShouldBeAErrorResponseWithMessage(int $statusCode, PyStringNode $errorMessage)
    {
        Assert::assertEquals(
            $statusCode,
            ApiClient::getLastResponse()->getStatusCode(),
            "Unexpected API response error status code."
        );
        
        Assert::assertEquals(
            ApiClient::getLastResponse()->getContent(),
            $errorMessage->getRaw()
        );
    }

    /**
     * @Then the response should be a :statusCode error response
     */
    public function theResponseShouldBeAStatusCodeErrorResponse(int $statusCode)
    {
        Assert::assertEquals(
            $statusCode,
            ApiClient::getLastResponse()->getStatusCode(),
            "Unexpected API response error status code."
        );
    }
    
    /**
    * @Then the response shoud be an access denied error response
    */
    public function theResponseShoudBeAnAccessDeniedErrorResponse()
    {
        Assert::assertEquals(
            403,
            ApiClient::getLastResponse()->getStatusCode(),
            "Unexpected API response error status code."
        );
        Assert::assertEquals(
            'Access Denied.',
            ApiClient::getLastResponse()->getContent()
        );
    }
}
