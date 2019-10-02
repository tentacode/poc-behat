<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;

class OkController
{
    /**
    * @Route("/api/ok")
    */
    public function __invoke(): JsonResponse
    {
        return new JsonResponse(['ok' => true]);
    }
}
