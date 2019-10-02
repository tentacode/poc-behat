<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserDeleteController
{
    private $userRepository;
    private $em;

    public function __construct(UserRepository $userRepository, ObjectManager $em)
    {
        $this->userRepository = $userRepository;
        $this->em = $em;
    }

    /**
    * @Route("/api/users/{userId}", methods={"DELETE"})
    */
    public function __invoke(int $userId): JsonResponse
    {
        $user = $this->userRepository->find($userId);

        $this->em->remove($user);
        $this->em->flush($user);

        return new JsonResponse(['ok' => true]);
    }
}
