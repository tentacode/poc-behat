<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\Query;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserListController
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
    * @Route("/api/users", methods={"GET"})
    */
    public function __invoke(): JsonResponse
    {
        $users = $this->userRepository
            ->createQueryBuilder('u')
            ->getQuery()
            ->getResult(Query::HYDRATE_ARRAY)
        ;

        return new JsonResponse($users);
    }
}
