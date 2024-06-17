<?php
// src/Controller/AgencyDashboardController.php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Review;

class AgencyDashboardController extends AbstractController
{
    #[Route('/dashboardavis', name: 'dashboard_avis')]
    public function userReviews(EntityManagerInterface $entityManager, PaginatorInterface $paginator, Request $request): Response
    {
        $currentUser = $this->getUser(); // Recup user courant 

        $searchTerm = $request->query->get('search', '');

        $queryBuilder = $entityManager->getRepository(Review::class)
            ->createQueryBuilder('r')
            ->leftJoin('r.user', 'u') // Jointer la table user
            ->where('r.nomAgence = :nomAgence')
            ->setParameter('nomAgence', $currentUser->getNomAgence());

        if ($searchTerm) {
            $queryBuilder->andWhere('u.email LIKE :searchTerm')
                ->setParameter('searchTerm', '%' . $searchTerm . '%');
        }

        $pagination = $paginator->paginate(
            $queryBuilder, /* Pas de resulatat  */
            $request->query->getInt('page', 1), /*Syteme numero de page*/
            10 /* 10 avis par page */
        );

        return $this->render('agency_dashboard/index.html.twig', [
            'user' => $currentUser,
            'pagination' => $pagination,
            'searchTerm' => $searchTerm,
        ]);
    }
}
