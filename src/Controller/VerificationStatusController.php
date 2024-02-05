<?php
// src/Controller/VerificationStatusController.php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;




class VerificationStatusController extends AbstractController
{
    #[Route('/compte/verification', name: 'page_non_verifiee')]
    #[IsGranted('ROLE_USER')]
    public function index(): Response
    {
        return $this->render('account_verification/index.html.twig');
    }
}
