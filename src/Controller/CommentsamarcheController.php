<?php

namespace App\Controller;
use App\Repository\CommentsamarcheRepository;  

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CommentsamarcheController extends AbstractController 
{
    private $Commentçamarche;

    public function __construct(CommentsamarcheRepository $Commentçamarche)
    {
        $this->Commentçamarche = $Commentçamarche;
    }

    #[Route('/Commentçamarche', name: 'app_commentsamarche')]
    public function index(): Response
    {
        $Commentçamarche = $this->Commentçamarche->find(1);

        return $this->render('commentsamarche/index.html.twig', [
            'Commentçamarche' => $Commentçamarche,
        ]);
    }
}
