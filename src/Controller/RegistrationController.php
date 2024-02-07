<?php
// RegistrationController.php pour les locataires

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Bundle\SecurityBundle\Security;
 
class RegistrationController extends AbstractController 
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }





    #[Route('/register', name: 'app_register')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, Security $security): Response
    {
        // Vérifiez si un utilisateur est connecté
        if ($security->getUser()) {
            // L'utilisateur est connecté, redirige vers une autre page ou renvoie une réponse personnalisée
            return $this->redirectToRoute('app_home'); // Ou renvoyez une réponse personnalisée indiquant la restriction d'accès
        }

        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            /////////////////////////////////////////////////Gestion du téléchargement du fichier PNG  ////////////////////////////////////

            $profilePictureFile = $form->get('profilePicture')->getData();
            if ($profilePictureFile) {
                $originalFilename = pathinfo($profilePictureFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $profilePictureFile->guessExtension();

                try {
                    $profilePictureFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/images/products',
                        $newFilename
                    );
                    $user->setProfilePicture($newFilename);
                } catch (FileException $e) {
                    $this->addFlash('danger', 'Une erreur s’est produite lors du téléchargement du fichier.');
                }
            }
            ///////////////////////////////////////////////// fin Gestion du téléchargement du fichier PNG  ////////////////////////////////////

            // Vérification de la valeur de employement_status
            if (null === $user->getEmployementStatus()) {
                // Si aucune valeur n'est sélectionnée, définir une valeur par défaut ou gérer l'erreur
                // Exemple : $user->setEmployementStatus('valeur_par_defaut');
            }
            // Définir le rôle à 'ROLE_LOCATAIRE'
            $user->setRoles(['ROLE_LOCATAIRE']);

            $entityManager->persist($user);
            $entityManager->flush();

            // ... code pour envoyer l'email de vérification ...

            // Redirection vers la page d'accueil avec un message de succès
            $this->addFlash('success', 'Votre inscription a été effectuée avec succès.');
            return $this->redirectToRoute('app_home');
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }








    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request, TranslatorInterface $translator): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $translator->trans($exception->getReason(), [], 'VerifyEmailBundle'));

            return $this->redirectToRoute('app_register');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_register');
    }
}
