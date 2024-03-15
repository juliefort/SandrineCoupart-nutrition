<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;


class DashboardController extends AbstractDashboardController
{
    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin', name: 'admin')]
    public function getDashboard(UserRepository $userRepo): Response
    {
        return $this->render('./dashboard/dashboard.html.twig', [
            'user' => $userRepo->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/contact/index', name: 'admin_contact_index')]
    public function getMessages(UserRepository $userRepo)
    {
        return $this->render('./contact/show.html.twig', [
            'user' => $userRepo->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/user/new', name: 'admin_user_new')]
    public function addUser(UserRepository $userRepo)
    {
        return $this->render('./user/new.html.twig', [
            'user' => $userRepo->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/user/new', name: 'admin_user_new')]
    public function showUser(UserRepository $userRepo)
    {
        return $this->render('./user/show.html.twig', [
            'user' => $userRepo->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/admin/recipes/new', name: 'admin_recipes_new')]
    public function addRecipes(UserRepository $userRepo)
    {
        return $this->render('./recipes/new.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('SandrineCoupart Nutrition');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
    }

    #[IsGranted('ROLE_USER')]
    #[Route('/logged', name: 'logged')]
    public function patientIsLogged() : Response
    {
        return $this->render('user/logged.html.twig');
    }

}
