<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ResultatController extends AbstractController
{

    #[Route('/theme/{id}/resultat', name: 'app_resultat', methods: ['GET'])]
    public function index(int $id): Response
    {


        return $this->render('resultat/index.html.twig', [
            'controller_name' => 'ResultatController',
        ]);
    }
}
