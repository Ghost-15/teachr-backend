<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class AuhtController extends AbstractController
{
    #[Route('/api/protected', name: 'protected_route', methods: ['GET'])]
    #[IsGranted('ROLE_USER')]
    public function getSecureInfos(): Response
    {
        return new JsonResponse(['message' => 'You have access to this restricted area!']);
    }
}
