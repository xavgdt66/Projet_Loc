<?php 
// src/Controller/Admin/UserListController.php

namespace App\Controller\Admin;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserListController extends AbstractController
{
    #[Route('/admin/liste-users', name: 'admin_liste_users')]
    public function listeUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy(['isVerified' => false]);

        return $this->render('admin/listeUser.html.twig', [
            'users' => $users
        ]);
    }
}
