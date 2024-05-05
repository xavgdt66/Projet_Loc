<?php
// src/Controller/AgencyDashboardController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Review;
use App\Entity\User; 

class AgencyDashboardController extends AbstractController
{
    #[Route('/dashboardavis', name: 'dashboard_avis')]
    public function userReviews(EntityManagerInterface $entityManager): Response
    {
        $currentUser = $this->getUser(); // Recup users courant 

        $userReviews = $entityManager->getRepository(Review::class)->findBy(['nomAgence' => $currentUser->getNomAgence()]);

        return $this->render('agency_dashboard/index.html.twig', [
            'user' => $currentUser,
            'reviews' => $userReviews,
        ]);
    }
}
