<?php
// src/Controller/UserController.php

namespace App\Controller;
use App\Form\UserSearchType;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class UserController extends AbstractController
{
       
    #[Route('/admin/liste-users', name: 'liste_users')]
    public function listeUsers(UserRepository $userRepository): Response
    {
        $users = $userRepository->findBy(['isVerified' => false]);

        return $this->render('admin/listeUser.html.twig', [
            'users' => $users
        ]);
    }


    #[Route('/search', name: 'search_users')]
    public function search(Request $request, UserRepository $userRepository): Response
    {
        $form = $this->createForm(UserSearchType::class);
        $form->handleRequest($request);

        $users = [];

        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->getData()['email'];
            $users = $userRepository->findByEmailAndRole($email, 'ROLE_LOCATAIRE');
        }

        return $this->render('user/search.html.twig', [
            'searchForm' => $form->createView(),
            'users' => $users,
        ]);
    }
}
