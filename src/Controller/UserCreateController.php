<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class UserCreateController
{
    private $em;

    public function __construct(ObjectManager $em)
    {
        $this->em = $em;
    }

    /**
    * @Route("/api/users", methods={"POST"})
    */
    public function __invoke(Request $request): JsonResponse
    {
        $user = new User();
        $user->setToken($request->request->get('token'));
        $user->setName($request->request->get('name'));
        $user->setEmail($request->request->get('email'));
        $user->setRole('ROLE_USER');

        $this->em->persist($user);
        $this->em->flush();

        return new JsonResponse([], JsonResponse::HTTP_CREATED);
    }
}
