<?php
// src/Service/VerificationStatusRedirector.php
/*namespace App\Service;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RouterInterface;
use App\Entity\User;
use Symfony\Bundle\SecurityBundle\Security;

class VerificationStatusRedirector
{ 
    private RouterInterface $router;
    private Security $security;

    public function __construct(RouterInterface $router, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
    }
    public function handleRequest(Request $request): ?RedirectResponse
    {
        // Récupérer l'utilisateur courant à partir du service Security
        $user = $this->security->getUser();
    
        if ($user instanceof User && !$user->isVerified()) {
            // Rediriger l'utilisateur non vérifié vers la page spécifique
            $targetUrl = $this->router->generate('page_non_verifiee');
            // Ajoutez ce log pour voir si la redirection est déclenchée
            var_dump("Redirecting to: " . $targetUrl);
            return new RedirectResponse($targetUrl);
        }

        var_dump("No redirection");

        return null;
    }
}*/