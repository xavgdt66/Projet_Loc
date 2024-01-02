<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Politiquedeconfidentilaite;
use App\Entity\User;

// Ajoutez les use nécessaires pour le UserRepository ou l'EntityManager
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\UserRepository;

class DashboardController extends AbstractDashboardController
{
    private $userRepository;

    // Si vous utilisez EntityManager, remplacez UserRepository par EntityManagerInterface
    public function __construct(private AdminUrlGenerator $adminUrlGenerator, UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        $countUsers = $this->countUsers();
        return Dashboard::new()
            ->setTitle('Location (' . $countUsers . ' utilisateurs)');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Aller sur le site', 'fas fa-undo', 'app_home');

        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToRoute('Statistique', 'fa fa-dashboard', 'admin_custom_dashboard');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-users', User::class);

         yield MenuItem::linkToCrud('Politique de confidentilaite', 'fa-solid fa-book-open', Politiquedeconfidentilaite::class);
    }

    private function countUsers()
    {
        // Si vous utilisez EntityManager, modifiez cette partie avec la requête DQL
        return $this->userRepository->count([]);
    }
}
