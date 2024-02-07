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
    public function index(UserInterface $user = null): Response
    {
        // Si l'utilisateur est connecté, redirigez-le vers une autre page ou affichez un contenu spécifique
        if ($user instanceof User && !$user->isVerified()) {
            return $this->redirectToRoute('page_non_verifiee');
        }

        // Si l'utilisateur n'est pas connecté, affichez la page de choix
        return $this->render('choice/index.html.twig', [
            'controller_name' => 'ChoiceController',
        ]);
    }
}