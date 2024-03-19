<?php

namespace App\Controller;

use App\Entity\Reviews;
use App\Form\ReviewsType;
use App\Repository\ReviewsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\RecipesRepository;
use App\Repository\UserRepository;

class ReviewsController extends AbstractController
{
    #[Route('/recipes/new/review', name: 'app_recipes_new_review', methods: ['GET','POST'])]
    public function index(Request $request, 
    EntityManagerInterface $entityManager, UserRepository $userRepo, RecipesRepository $recipesRepo, ReviewsRepository $reviewsRepo): Response
    {
        $reviews = new Reviews();
        $form = $this->createForm(ReviewsType::class, $reviews);
        $form->handleRequest($request);

        // Vérification si le formulaire a été soumis et si il est valide
        if($form->isSubmitted() && $form->isValid()) { 
    
            $reviews = $form->getData();
            $entityManager->persist($reviews);
            $entityManager->flush(); // Mise à jour vers la base de données

            return $this->redirectToRoute('app_user');
        }
        return $this->render('/reviews/new.html.twig', [
            'controller_name' => 'ReviewsController',
            'form' => $form,
            'user' => $userRepo->findBy([], []),
            'reviews' => $reviewsRepo->findAll(),
        ]);
    }
}
