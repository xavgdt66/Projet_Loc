<?php
// RegistrationAgenceController.php 
namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationAgenceFormType;  
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
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class RegistrationAgenceController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/registeragence', name: 'app_registeragence')]
    public function register(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager,Security $security): Response
    {

         // Vérifiez si un utilisateur est connecté
         if ($security->getUser()) {
            // L'utilisateur est connecté, redirige vers une autre page ou renvoie une réponse personnalisée
            return $this->redirectToRoute('app_home'); // Ou renvoyez une réponse personnalisée indiquant la restriction d'accès
        }
        $user = new User();
        $form = $this->createForm(RegistrationAgenceFormType::class, $user);
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

        /////////////////////////// gestion du téléchargement du fichier PDF ////////////////////

        $KbisPictureFile = $form->get('kbis')->getData();
        if ($KbisPictureFile) {
            $originalFilenamekbis = pathinfo($KbisPictureFile->getClientOriginalName(), PATHINFO_FILENAME);
            $newFilenamekbis = $originalFilenamekbis . '-' . uniqid() . '.' . $KbisPictureFile->guessExtension();
            try {
                $KbisPictureFile->move(
                    $this->getParameter('kernel.project_dir') . '/public/images/pdf',
                    $newFilenamekbis
                );
                $user->setKbis($newFilenamekbis);  
            } catch (FileException $e) {
                $this->addFlash('danger', 'Une erreur s’est produite lors du téléchargement du fichier.');
            } }



        ///////////////////////////fin Gestion du téléchargement du fichier PDF   /////////




            $user->setRoles(['ROLE_AGENCY']);


            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
           /* $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('noreply@gmail.com', 'Xavier'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('registration/confirmation_email.html.twig')
            );*/
            // do anything else you need here, like send an email

            $this->addFlash('success', 'Votre inscription a été effectuée avec succès.');
            return $this->redirectToRoute('app_home');
        }

        var_dump($request->files->get('profilePicture'));


        return $this->render('registration/registeragence.html.twig', [
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
