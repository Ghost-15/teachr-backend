<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/routeC", name: "app_categorie")]
class CategorieController extends AbstractController {
    #[Route("/allCategorie", name: "all_categorie")]
    public function allProduct (CategorieRepository $repository, EntityManagerInterface $entityManager): Response {
        $data = $repository->findAll();
        if (!$data) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        }

        foreach ($data as $c){
            $categorie[] =[
                'id' => $c->getId(),
                'nom' => $c->getNom(),
            ];
        }
        return new JsonResponse($categorie);
    }
    #[Route('/addCategorie', name: 'create_categorie', methods: ['POST'])]
    public function createProduct(Request $request, EntityManagerInterface $entityManager): Response {
        $categorie = new Categorie();

        $parameter = json_decode($request->getContent(), true);

        $categorie->setNom($parameter['nom']);

        $entityManager->persist($categorie);
        $entityManager->flush();

        $response = new Response();
//        $response->setContent('User created successfully');
//        $response->setData([ 'message' => 'User created successfully', 'status' => 'success' ]);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
    #[Route('/udapteCategorie', name: 'udapte_categorie', methods: ['POST'])]
    public function udapteProduct(Request $request, EntityManagerInterface $entityManager): Response {
        $parameter = json_decode($request->getContent(), true);

        $categorie = $entityManager->getRepository(Categorie::class)->find($parameter['c_id']);

        if (!$categorie) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        }

        $categorie->setNom($parameter['nom']);

        $entityManager->flush();

        $response = new Response();
//        $response->setContent('User created successfully');
//        $response->setData([ 'message' => 'User created successfully', 'status' => 'success' ]);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
//    #[IsGranted('ROLE_ADMIN')]
    #[Route('/deteleC/{id}', name: 'deteleC')]
    public function deteleProduct(EntityManagerInterface $entityManager, int $id): Response {

        $categorie = $entityManager->getRepository(Categorie::class)->find($id);

        if (!$categorie) {
            throw $this->createNotFoundException(
                'No categorie found'
            );
        }
            $entityManager->remove($categorie);
            $entityManager->flush();

        $response = new Response();
//        $response->setContent('User created successfully');
//        $response->setData([ 'message' => 'User created successfully', 'status' => 'success' ]);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
}