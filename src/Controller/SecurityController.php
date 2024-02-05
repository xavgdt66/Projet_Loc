<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use App\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class SecurityController extends AbstractController implements AuthenticationSuccessHandlerInterface
{

    #[Route(path: '/security/check', name: 'security_check')]
    public function check(UserInterface $user): Response
    {
        if ($user instanceof User && !$user->isVerified()) {
            return $this->redirectToRoute('app_contact');
        }
        // Rediriger l'utilisateur vers la page d'accueil
        return $this->redirectToRoute('app_home');
    }


    #[Route(path: '/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home');
        }
        // obtenir l'erreur de connexion s'il y en a une
        $error = $authenticationUtils->getLastAuthenticationError();
        // dernier nom d'utilisateur saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }


    #[Route(path: '/logout', name: 'app_logout')]
    public function logout()
    {
        // Vérifier si l'utilisateur est connecté
        if (!$this->getUser()) {
            // Rediriger l'utilisateur vers une autre page, par exemple la page d'accueil
            return $this->redirectToRoute('app_home');
        }
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): ?Response
    {
        // Obtenir l'utilisateur et vérifier s'il s'agit d'une instance de votre classe User
        $user = $token->getUser();

        // Ajoutez une vérification temporaire pour déboguer
        if (!$user instanceof \App\Entity\User) {
            throw new \Exception('L\'utilisateur n\'est pas une instance de la classe User');
        }

        if (!$user->isVerified()) {
            // Rediriger vers la page de vérification
            return $this->redirectToRoute('compte_verification');
        }
        // Rediriger vers la page d'accueil
        return $this->redirectToRoute('accueil');
    }
}
