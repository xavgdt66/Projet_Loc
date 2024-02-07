<?php

namespace App\Controller;

use App\Repository\PolitiquedeconfidentilaiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PoliticsController extends AbstractController
{ 
    private $polRepository; 

    public function __construct(PolitiquedeconfidentilaiteRepository $polRepository)
    {
        $this->polRepository = $polRepository;
    }

    #[Route('/politique-de-confidentialite', name: 'app_politics')]
    public function index(): Response
    {
        // Récupération de la donnée avec l'ID 1
        $politique = $this->polRepository->find(1);

        // Passer les données à la vue
        return $this->render('politics/index.html.twig', [
            'politique' => $politique,
        ]);
    }
}
