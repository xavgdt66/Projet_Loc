<?php

namespace App\Controller\Admin;

use App\Controller\MentionsLegalesController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use App\Entity\Politiquedeconfidentilaite;
use App\Entity\Mentionlegale; 

use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
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
        // Vérifiez si l'utilisateur a le rôle ADMIN
        if (!$this->isGranted('ROLE_ADMIN')) {
            // Redirigez l'utilisateur vers la route app_home s'il n'est pas administrateur
            return $this->redirectToRoute('app_home');
        }

        return $this->render('admin/dashboard.html.twig');
    }

 

    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    #[Route('/admin/liste-users', name: 'liste_users')]
    public function listeUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy(['isVerified' => false]);

        return $this->render('admin/listeUser.html.twig', [
            'users' => $users
        ]);
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
        yield MenuItem::linkToRoute('ValidateUsers', 'fa fa-users','admin_liste_users');

        yield MenuItem::linkToCrud('Politique de confidentilaite', 'fa-solid fa-book-open', Politiquedeconfidentilaite::class);
        yield MenuItem::linkToCrud('Mention legale', 'fa-solid fa-book-open', Mentionlegale::class);

    }

    private function countUsers()
    {
        // Si vous utilisez EntityManager, modifiez cette partie avec la requête DQL
        return $this->userRepository->count([]);
    }
}
