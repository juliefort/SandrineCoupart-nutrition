<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\AllergensRepository;
use App\Repository\DietRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class UserController extends AbstractController
{
    public $entityManager;
    
    public function __construct(EntityManagerInterface $entityManager, public UserPasswordHasherInterface $userPasswordHasher) 
    {
        $this->entityManager = $entityManager;
        $this->userPasswordHasher = $userPasswordHasher;
    }

    #[Route('/user/register', name: 'app_user_register')]
    public function registerPatient(UserRepository $userRepo, Request $request, 
    EntityManagerInterface $entityManager,DietRepository $dietRepo, 
    AllergensRepository $allergensRepo): Response
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        // Vérification si le formulaire a été soumis et si il est valide
        if($form->isSubmitted() && $form->isValid()) { 
            $password = $user->getPassword();
            $hashedPassword = $this->userPasswordHasher->hashPassword($user, $password);
            $user->setPassword($hashedPassword);

            $roles = $user->getRoles();
            // Enregistre les rôles dans l'entité User
            $user->setRoles($roles);

            $user = $form->getData();
            $entityManager->persist($user);
            $entityManager->flush(); // Mise à jour vers la base de données

            return $this->redirectToRoute('app_user');
        }
        return $this->render('user/form.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->CreateView(),
            'user' => $userRepo->findBy([], []),
            'diet' => $dietRepo->findBy([],[]),
            'allergens' => $allergensRepo->findBy([],[]),
        ]);
    }

    #[Route('/user', name: 'app_user')]
    public function users(UserRepository $userRepo, DietRepository $dietRepo, 
    AllergensRepository $allergensRepo): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
            'user' => $userRepo->findAll(),
            'diet' => $dietRepo->findAll(),
            'allergens' => $allergensRepo->findAll(),
        ]);
    }

}

