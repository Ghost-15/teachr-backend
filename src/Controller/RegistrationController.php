<?php

namespace App\Controller;

use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Error;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;

class RegistrationController extends AbstractController
{
    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher,
                             EntityManagerInterface $entityManager): Response
    {
        $data = json_decode($request->getContent(), true);

        $app = new User();

        $app->setUsername($data['username']);
        $app->setEmail($data['email']);
        $app->setPassword($userPasswordHasher->hashPassword($app, $data['password']));
        if ($data['role'] === ""){
            $app->setRoles((array)"ROLE_USER");
        } else {
            $app->setRoles((array)$data['role']);
        }

        $response = new Response();

        try {
            $entityManager->persist($app);
            $entityManager->flush();

//            $mail = (new Email())
//                ->from('tatibatchi15@gmail.com')
//                ->to('tatibatchi15@hotmail.com')
//                ->subject('Test Email')
//                ->text('This is a test email.');
//
//            $mailer->send($mail);

            $response->setStatusCode(Response::HTTP_OK);
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        } catch (Error $e){
            $response->setStatusCode($e->getCode());
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        }
    }

//    #[Route('/verify/email', name: 'app_verify_email')]
//    public function verifyUserEmail(Request $request): Response
//    {
//        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
//
//        // validate email confirmation link, sets User::isVerified=true and persists
//        try {
//            /** @var User $user */
//            $user = $this->getUser();
//            $this->emailVerifier->handleEmailConfirmation($request, $user);
//        } catch (VerifyEmailExceptionInterface $exception) {
//            $this->addFlash('verify_email_error', $exception->getReason());
//
//            return $this->redirectToRoute('app_register');
//        }
//
//        // @TODO Change the redirect on success and handle or remove the flash message in your templates
//        $this->addFlash('success', 'Your email address has been verified.');
//
//        return $this->redirectToRoute('app_register');
//    }
}
