<?php

declare(strict_types=1);

namespace Tests\Behat\User;

use App\Repository\UserRepository;
use Behat\Behat\Context\Context;
use PHPUnit\Framework\Assert;
use Tests\Behat\Api\ApiClient;

final class UserContext implements Context
{

    /** @var ApiClient */
    private $client;

    /** @var UserRepository */
    private $userRepository;

    public function __construct(ApiClient $client, UserRepository $userRepository)
    {
        $this->client = $client;
        $this->userRepository = $userRepository;
    }

    /**
    * @When I delete the :userName user
    */
    public function iDeleteTheUser(string $userName)
    {
        $user = $this->userRepository->findOneByName($userName);
        Assert::assertNotNull($user, sprintf(
            'User with name "%s" does not exist.',
            $userName
        ));

        $this->client->request(sprintf(
            '/users/%s',
            $user->getId()
        ), 'DELETE');
    }

    /**
     * @Then the user :userName should have been deleted
     */
    public function theUserShouldHaveBeenDeleted(string $userName)
    {
        $user = $this->userRepository->findOneByName($userName);

        Assert::assertNull($user, sprintf(
            'User with name "%s" was found but should not exist.',
            $userName
        ));
    }
}
