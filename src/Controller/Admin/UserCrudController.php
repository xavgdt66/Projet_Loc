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
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Filter\TextFilter;

#[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
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
            ->add(ChoiceFilter::new('roles', 'Rôle')->setChoices([
                'Agency' => 'ROLE_AGENCY',
                'Locataire' => 'ROLE_LOCATAIRE',
            ]));
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

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('password')->hideOnIndex(),
            BooleanField::new('is_verified', 'Utilisateur verifier'),
            TextField::new('nom_rue', 'Street Name'),
            TextField::new('kbis'),
            ImageField::new('profile_picture')
                ->setBasePath('/images/products')
                ->setUploadDir('public/images/products')
                ->setUploadedFileNamePattern('[randomhash].[extension]')
                ->setRequired(false),
            TextField::new('first_name', 'First Name'),
            TextField::new('last_name', 'Last Name')->setRequired(false), // peut etre vide via setRequired(false)
            IntegerField::new('telephone'),
            TextareaField::new('address'),
            TextareaField::new('presentation')->setRequired(false), // peut etre vide via setRequired(false)
            IntegerField::new('net_income', 'Net Income'),
            TextField::new('nom_agence', 'Agency Name'),
            IntegerField::new('numero_rue', 'Street Number'),
            IntegerField::new('code_postal', 'Postal Code'),
            TextField::new('ville', 'City'),
            IntegerField::new('carte_professionnelle', 'Professional Card Number'),
            IntegerField::new('siren'),
            IntegerField::new('siret'),
            DateTimeField::new('updated_at', 'Updated At')->hideOnForm()
        ];
    }
}
