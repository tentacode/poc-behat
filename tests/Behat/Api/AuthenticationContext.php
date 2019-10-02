<?php

declare(strict_types=1);

namespace Tests\Behat\Api;

use App\Repository\UserRepository;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;

final class AuthenticationContext implements Context
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
     * @BeforeScenario
     */
    public function authenticateRequest(BeforeScenarioScope $scope)
    {
        foreach ($scope->getScenario()->getTags() as $tag) {
            // tag is like @user("John Doe")
            if (preg_match('/^user\(([^)]+)\)$/', $tag, $matches)) {
                $userName = $matches[1];
                $userName = trim($userName, '"\'');

                $user = $this->userRepository->findOneByName($userName);
                
                $this->client->setHeader('Authorization', sprintf(
                    'Bearer %s',
                    $user->getToken()
                ));
            }
        }
    }
}
