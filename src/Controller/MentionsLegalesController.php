<?php

namespace App\Controller;

use App\Repository\MentionlegaleRepository; 
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MentionsLegalesController extends AbstractController
{
    private $MlRepository;

    public function __construct(MentionlegaleRepository $MlRepository)
    {
        $this->MlRepository = $MlRepository;
    }

    #[Route('/mentions/legales', name: 'app_mentions_legales')]
    public function index(): Response
    {
        $Mentionlegale = $this->MlRepository->find(1);

        return $this->render('mentions_legales/index.html.twig', [
            'Mentionlegale' => $Mentionlegale,
        ]);
    }
} 
