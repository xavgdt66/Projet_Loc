<?php 
// src/Controller/Admin/UserListController.php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;



#[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
class UserListController extends AbstractController
{
    #[Route('/admin/liste-users', name: 'admin_liste_users')]
    public function listeUsers(UserRepository $userRepository): Response
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            // Redirigez l'utilisateur vers la route app_home s'il n'est pas administrateur
            return $this->redirectToRoute('app_home');
        }

        $users = $userRepository->findBy(['isVerified' => false]);

        return $this->render('admin/listeUser.html.twig', [
            'users' => $users
        ]);
    }
}
