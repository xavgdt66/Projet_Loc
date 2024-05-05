<?php
// src/Controller/ProfileController.php
namespace App\Controller;

use App\Entity\Review;
use App\Entity\User;
use App\Form\UserType;
use App\Form\ReviewType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Bundle\SecurityBundle\Security;

class ProfileController extends AbstractController
{

    public function __construct(Security $security)
    {
    }


    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(Request $request, User $user, EntityManagerInterface $entityManager, Security $security): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED');

        if (!$security->isGranted('ROLE_AGENCY') && !$security->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_home');
        }

        $review = new Review();
        $form = $this->createForm(ReviewType::class, $review);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $existingReview = $entityManager->getRepository(Review::class)->findOneBy([
                'user' => $user,
                'startDate' => $review->getStartDate(),
                'endDate' => $review->getEndDate()
            ]);

            if ($existingReview) {
                $this->addFlash('error', 'Une note existe déjà pour cette période.');
            } else {
                $review->setUser($user);

                $currentUser = $this->getUser();
                $review->setNomAgence($currentUser->getNomAgence());

                $entityManager->persist($review);
                $entityManager->flush();

                $this->addFlash('success', 'Votre avis a été enregistré avec succès.');
            }

            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }

        $reviews = $user->getReviews();

        $totalMonthsPaid = 0;
        foreach ($reviews as $review) {
            $start = $review->getStartDate();
            $end = $review->getEndDate();

            $interval = $start->diff($end);
            $months = $interval->y * 12 + $interval->m;
            if ($interval->d > 0) {
                $months++; 
            }

            $totalMonthsPaid += $months;
        }

        $agenceNom = $user->getNomAgence();

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'form' => $form->createView(),
            'reviews' => $reviews,
            'totalMonthsPaid' => $totalMonthsPaid,
            'agenceNom' => $agenceNom,
        ]);
    }












    // Cette route permet aux users de voir leur profil public meme si il ne sont pas verifier 
    #[Route('/myprofile', name: 'app_my_profile')]
    public function myProfile(EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();

        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }
        return $this->render('profile/index.html.twig', ['user' => $user,]);
    }


    // Cette route permet aux users de modifier leur profil public meme si il ne sont pas verifier 
    #[Route('/edit-my-profile', name: 'app_edit_my_profile')]
    public function editMyProfile(Request $request, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user) {
            throw $this->createNotFoundException('Utilisateur non trouvé');
        }

        $form = $this->createForm(UserType::class, $user, [
            'user_roles' => $user->getRoles(), // Ajoutez les rôles de l'utilisateur ici
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications de l'utilisateur
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès.');
            return $this->redirectToRoute('app_my_profile'); // Redirection vers la page du profil
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user 
        ]);
    }
}
