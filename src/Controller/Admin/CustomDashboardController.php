<?php
// src/Controller/Admin/CustomDashboardController.php

namespace App\Controller\Admin;

use App\Repository\UserRepository;

use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\ExpressionLanguage\Expression;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class CustomDashboardController extends AbstractDashboardController
{

    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    #[Route('/admin/custom-dashboard', name: 'admin_custom_dashboard')]
    #[IsGranted(new Expression('is_granted("ROLE_ADMIN")'))]
    public function index(): Response
    {
        // Logique pour récupérer les données, par exemple, le nombre d'utilisateurs
        $userCount = $this->userRepository->count([]); // le nombre d'utilisateurs
      $tenantCountLocataire = $this->userRepository->countUsersByRole('ROLE_LOCATAIRE'); // le nombre de locataire 
      $tenantCountAgence = $this->userRepository->countUsersByRole('ROLE_AGENCY'); // le nombre d'agence 

        // Renvoyer la vue personnalisée avec les données
        return $this->render('admin/statisticalUser.html.twig', [
            'userCount' => $userCount,
            'tenantCountLocataire' => $tenantCountLocataire,
            'tenantCountAgence' => $tenantCountAgence,

        ]);
    }





}
