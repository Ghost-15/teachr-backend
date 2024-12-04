<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
class AuthController extends AbstractController {

    #[Route('/register', name: 'app_register')]
//    #[ParamConverter('user', class: 'App\Entity\User')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager): Response {
        $user = new User();

        $parameter = json_decode($request->getContent(), true);

        $user->setFullName($parameter['full_name']);
        $user->setUsername($parameter['username']);
        $user->setPassword(
            $userPasswordHasher->hashPassword(
                $user,
                $parameter->get('password')->getData()
            ));

        $entityManager->persist($user);
        $entityManager->flush();

        $response = new Response();
//        $response->setContent('User created successfully');
//        $response->setData([ 'message' => 'User created successfully', 'status' => 'success' ]);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
}