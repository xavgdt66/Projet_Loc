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

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
class ProfileController extends AbstractController
{

    #[Route('/profile/{id}', name: 'app_profile')]
    public function index(UserInterface $currentUser, User $profileUser,Request $request,AuthorizationCheckerInterface $authorizationChecker): Response 
    {
        // Check if the current user is not verified
        if ($currentUser instanceof User && !$currentUser->isVerified()) {
            return $this->redirectToRoute('page_non_verifiee');
        }

        // Check if the profile user is not verified
        if (!$profileUser->isVerified()) {
            return $this->redirectToRoute('page_non_verifiee');
        }

        // Vérifiez si l'utilisateur a le rôle "Admin" ou "Agency"
        if ($authorizationChecker->isGranted('ROLE_ADMIN') || $authorizationChecker->isGranted('ROLE_AGENCY')) {
            // Continuez avec le code existant si l'utilisateur a le bon rôle
            $reviews = $profileUser->getReviews();
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

            $form = $this->createForm(ReviewType::class);
            $form->handleRequest($request);

            // Votre code pour la soumission du formulaire et le rendu de la page
            return $this->render('profile/index.html.twig', [
                'user' => $profileUser,
                'reviews' => $reviews,
                'totalMonthsPaid' => $totalMonthsPaid,
                'form' => $form->createView(),
            ]);
        }

        // Redirigez les utilisateurs qui n'ont pas le rôle vers la route "home"
        return $this->redirectToRoute('app_home');
    }


































    #[Route('/profile/edit/{id}', name: 'app_profile_edit')]
    public function edit(Request $request, User $user, EntityManagerInterface $entityManager): Response
    {
        // Assurez-vous que l'utilisateur connecté est le même que celui du profil ou qu'il a un rôle spécial (comme admin)
        $this->denyAccessUnlessGranted('ROLE_USER');
        if ($user != $this->getUser() && !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Enregistrer les modifications
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Profil mis à jour avec succès.');

            return $this->redirectToRoute('app_profile', ['id' => $user->getId()]);
        }

        return $this->render('profile/edit.html.twig', [
            'form' => $form->createView(),
            'user' => $user
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

        // Récupération des avis liés à l'utilisateur
        $reviews = $entityManager->getRepository(Review::class)->findBy(['user' => $user]);

        // Calculer le nombre total de mois de loyers payés
        $totalMonthsPaid = 0;
        foreach ($reviews as $review) {
            $start = $review->getStartDate();
            $end = $review->getEndDate();

            // Calculer le nombre de mois couverts par cet avis
            $interval = $start->diff($end);
            $months = $interval->y * 12 + $interval->m;
            if ($interval->d > 0) {
                $months++; // Considérer les jours partiels comme un mois entier
            }
            $totalMonthsPaid += $months;
        }

        return $this->render('profile/index.html.twig', [
            'user' => $user,
            'reviews' => $reviews,
            'totalMonthsPaid' => $totalMonthsPaid
        ]);
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
            'user' => $user // Assurez-vous de passer l'objet User à la vue
        ]);
    }
}
