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
    #[Route('/admin', name: 'admin')]
    public function getDashboard(UserRepository $userRepo): Response
    {
        return $this->render('./dashboard/dashboard.html.twig', [
            'user' => $userRepo->findAll(),
        ]);
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
