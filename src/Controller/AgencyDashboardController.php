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
    #[Route('/dashboardavis', name: 'user_dashboard')]
    public function userReviews(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser(); 
        $reviews = $entityManager->getRepository(Review::class)->findBy(['user' => $user]);

        return $this->render('agency_dashboard/index.html.twig', [
            'user' => $user,
            'reviews' => $reviews,
        ]);
    }
}
