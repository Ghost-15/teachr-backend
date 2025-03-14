<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Repository\ProduitRepository;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route("/routeP", name: "app_product")]
class ProduitController extends AbstractController {

    #[Route('/getProduct/{value}', name: 'get_product')]
    public function getProduct(string $value, EntityManagerInterface $entityManager): Response
    {
        $product = $entityManager->getRepository(Produit::class)->findOneBy(['id' => $value]);

        $p[] =[
            'n' => $product->getNom(),
            'd' => $product->getDescription(),
            'p' => $product->getPrix()
        ];

        return new JsonResponse($p);
    }
    #[Route("/allProduct", name: "all_product")]
    public function allProduct (ProduitRepository $repository): Response {
        $data = $repository->findAll();
        if (!$data) {
            throw $this->createNotFoundException(
                'No product found'
            );
        }
        foreach ($data as $p){
            $products[] =[
                'id' => $p->getId(),
                'nom' => $p->getNom(),
                'description' => $p->getDescription(),
                'prix' => $p->getPrix(),
                'categorie' => $p->getCategorie(),
                'creation' => $p->getCreation()
            ];
        }
        return new JsonResponse($products);
    }
    #[Route('/addProduct', name: 'create_product', methods: ['POST'])]
    public function createProduct(Request $request, EntityManagerInterface $entityManager): Response {
        $produit = new Produit();

        $parameter = json_decode($request->getContent(), true);

        $produit->setNom($parameter['nom']);
        $produit->setDescription($parameter['description']);
        $produit->setPrix($parameter['prix']);
        if ($parameter['selectedCategory'] === ""){
            $response = new Response();
            $response->setStatusCode(404);
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        } else {
            $produit->setCategorie($parameter['selectedCategory']);
        }
        $creation = new DateTime();
        $produit->setCreation($creation);

        $entityManager->persist($produit);
        $entityManager->flush();

        $response = new Response();
//        $response->setContent('User created successfully');
//        $response->setData([ 'message' => 'User created successfully', 'status' => 'success' ]);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
    #[Route('/udapteProduct', name: 'udapte_product', methods: ['POST'])]
    public function udapteProduct(ProduitRepository $repository,
                                  Request $request, EntityManagerInterface $entityManager): Response {
        $parameter = json_decode($request->getContent(), true);

        $produit = $repository->find($parameter['p_id']);

        if (!$produit) {
            $response = new Response();
            $response->setStatusCode(404);
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        }

        $produit->setNom($parameter['nom']);
        $produit->setDescription($parameter['description']);
        $produit->setPrix($parameter['prix']);
        if ($parameter['selectedCategory'] === ""){
            $response = new Response();
            $response->setStatusCode(404);
            $response->headers->set('Content-Type', 'text/plain');
            return $response;
        } else {
            $produit->setCategorie($parameter['selectedCategory']);
        }
        $entityManager->flush();

        $response = new Response();
//        $response->setContent('User created successfully');
//        $response->setData([ 'message' => 'User created successfully', 'status' => 'success' ]);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/deteleP/{id}', name: 'deteleP')]
    public function deteleProduct(EntityManagerInterface $entityManager, int $id): Response {

        $product = $entityManager->getRepository(Produit::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        $response = new Response();
//        $response->setContent('User created successfully');
//        $response->setData([ 'message' => 'User created successfully', 'status' => 'success' ]);
        $response->setStatusCode(Response::HTTP_OK);
        $response->headers->set('Content-Type', 'text/plain');
        return $response;
    }
}