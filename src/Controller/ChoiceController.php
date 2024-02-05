<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bundle\SecurityBundle\Security;


use App\Entity\User;




class ChoiceController extends AbstractController
{
    #[Route('/choice', name: 'app_choice')]
    public function index(UserInterface $user,Security $security): Response 
    {
        /*if ($user instanceof User && !$user->isVerified()) { // Vérifiez si un utilisateur est verifier 
            return $this->redirectToRoute('page_non_verifiee'); // Si il n'est pas verifier il est renvoye vers la page_non_verifie
        }*/
          // Vérifiez si un utilisateur est connecté
          if ($security->getUser()) {
            // L'utilisateur est connecté, redirige vers une autre page ou renvoie une réponse personnalisée
            return $this->redirectToRoute('app_home'); // Ou renvoyez une réponse personnalisée indiquant la restriction d'accès
        }
       

        return $this->render('choice/index.html.twig', [
            'controller_name' => 'ChoiceController',
        ]);
    }
}
