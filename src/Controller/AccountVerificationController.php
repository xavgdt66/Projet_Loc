<?php
// src/Controller/AccountVerificationController.php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AccountVerificationController extends AbstractController
{
    
    #[Route('/compte/verification', name: 'compte_verification')]

    public function index(): Response
    {
        return $this->render('account_verification/index.html.twig');
    }
}
