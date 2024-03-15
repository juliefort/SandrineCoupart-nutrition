<?php

namespace App\Controller;

use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Repository\UserRepository;
use App\Entity\Contact;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact', methods: ['GET','POST'])]
    public function index(Request $request, 
    EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        // Vérification si le formulaire a été soumis et si il est valide
        if($form->isSubmitted() && $form->isValid()) { 
    
            $contact = $form->getData();
            $entityManager->persist($contact);
            $entityManager->flush(); // Mise à jour vers la base de données

            return $this->redirectToRoute('app_home');
        }
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' => $form,
        ]);
    }

    #[Route('/admin/contact/index', name: 'admin_contact_index', methods: 'GET')]
    public function adminContact(ContactRepository $contactRepo, UserRepository $userRepo)
    {
        return $this->render('contact/show.html.twig', [
            'controller_name' => 'ContactController',
            'contact' => $contactRepo->findBy([], []),
            'user' => $userRepo->findBy([], []),
        ]);
    }
}
