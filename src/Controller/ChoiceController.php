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
        if ($user instanceof User && !$user->isVerified()) {
            return $this->redirectToRoute('app_home');
        }

        return $this->render('choice/index.html.twig', [
            'controller_name' => 'ChoiceController',
        ]);
    }
}