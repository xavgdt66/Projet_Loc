<?php 
// src/Controller/Admin/UserCrudController.php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserCrudController extends AbstractCrudController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setPageTitle(Crud::PAGE_INDEX, 'Liste des Utilisateurs')
            // Autres configurations...
            ;
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('isVerified', 'Utilisateur Validé'));
    }

    /**
     * @Route("/admin/validate-user/{id}", name="admin_validate_user")
     */
    public function validateUser(int $id, Request $request): RedirectResponse
    {
        $user = $this->userRepository->find($id);

        if ($user && !$user->isVerified()) {
            $user->setIsVerified(true);
            $this->entityManager->flush();
            $this->addFlash('success', 'Utilisateur validé avec succès.');
        }

        return $this->redirect($request->headers->get('referer'));
    }
}
