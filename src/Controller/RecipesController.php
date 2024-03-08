<?php

namespace App\Controller;

use App\Entity\Recipes;
use App\Form\RecipesType;
use App\Repository\AllergensRepository;
use App\Repository\DietRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;


class RecipesController extends AbstractController
{

    #[Route('/recipes/new', name: 'app_recipes/new', methods: ['GET','POST'])]
    public function addRecipe(Request $request, 
    EntityManagerInterface $entityManager, DietRepository $dietRepo, 
    AllergensRepository $allergensRepo, UserRepository $userRepo
    ): Response
    {
        $recipes = new Recipes();
        $form = $this->createForm(RecipesType::class, $recipes);
        $form->handleRequest($request);

        // Vérification si le formulaire a été soumis et si il est valide
        if($form->isSubmitted() && $form->isValid()) { 
    
            $recipes = $form->getData();
            $entityManager->persist($recipes);
            $entityManager->flush(); // Mise à jour vers la base de données

            return $this->redirectToRoute('app_user');
        }
        return $this->render('recipes/new.html.twig', [
            'controller_name' => 'RecipesController',
            'form' => $form->createView(),
            'diet' => $dietRepo->findBy([],[]),
            'allergens' => $allergensRepo->findBy([],[]),
            'user' => $userRepo->findBy([], []),
        ]);
    }
}
