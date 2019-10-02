<?php

declare(strict_types=1);

namespace Tests\Behat\Api;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\PyStringNode;
use PHPUnit\Framework\Assert;

use function Safe\json_decode;

final class JsonResponseContext implements Context
{
    /**
     * @Then the response should match:
     */
    public function theResponseShouldMatch(PyStringNode $expectedResponse): void
    {
        ApiAssert::assertMatchJsonPattern(
            (string)ApiClient::getLastResponse()->getContent(),
            $expectedResponse->getRaw()
        );
    }
    
    /**
     * @Then /^the response should have (\d+) items?$/
     */
    public function theResponseShouldHaveItems(int $count)
    {
        $jsonString = (string)ApiClient::getLastResponse()->getContent();
        $jsonArray = json_decode($jsonString, true);

        Assert::assertIsArray($jsonArray);
        Assert::assertCount($count, $jsonArray);
    }
}
