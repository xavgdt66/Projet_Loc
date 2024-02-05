<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class ValidateUserController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private UserRepository $userRepository;

    public function __construct(EntityManagerInterface $entityManager, UserRepository $userRepository)
    {
        $this->entityManager = $entityManager;
        $this->userRepository = $userRepository;
    }

    
    #[Route('/admin/validate-user/{id}', name: 'admin_validate_user')]
    public function validateUser($id): RedirectResponse
{
    if (!$this->isGranted('ROLE_ADMIN')) {
        // Redirigez l'utilisateur vers la route app_home s'il n'est pas administrateur
        return $this->redirectToRoute('app_home');
    }
    $user = $this->userRepository->find($id);
    if ($user && !$user->isVerified()) {
        $user->setIsVerified(true);
        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été validé avec succès.');
    }

    return $this->redirectToRoute('admin_liste_users'); // Utilisez le nom de la route que vous avez créé
}
}
