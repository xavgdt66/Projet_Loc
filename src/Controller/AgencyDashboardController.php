<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Review;

class AgencyDashboardController extends AbstractController
{
    #[Route('/dashboardavis', name: 'user_dashboard')]
    public function index(): Response
    {
        $user = $this->getUser();

        $reviews = $user->getReviews();

        return $this->render('agency_dashboard/index.html.twig', [
            'reviews' => $reviews,
        ]);
    }
}
