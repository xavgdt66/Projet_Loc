<?php

namespace App\Controller;

use App\Entity\User;

use App\Repository\MentionlegaleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Bundle\SecurityBundle\Security;
 
class MentionsLegalesController extends AbstractController
{
    private $MlRepository; 

    public function __construct(MentionlegaleRepository $MlRepository)
    {
        $this->MlRepository = $MlRepository;
    }

    #[Route('/mentions/legales', name: 'app_mentions_legales')]
    public function index(Security $security): Response
    {
        // Vérifiez si un utilisateur est connecté
        if ($security->getUser()) {
            // L'utilisateur est connecté, redirige vers une autre page ou renvoie une réponse personnalisée
            return $this->redirectToRoute('app_contact'); // Ou renvoyez une réponse personnalisée indiquant la restriction d'accès
        }

        $Mentionlegale = $this->MlRepository->find(1);


        return $this->render('mentions_legales/index.html.twig', [
            'Mentionlegale' => $Mentionlegale,
        ]);
    }
}
