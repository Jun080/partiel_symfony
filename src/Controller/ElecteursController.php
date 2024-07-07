<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ElecteursController extends AbstractController
{
    #[Route('/electeurs', name: 'app_electeurs')]
    public function index(): Response
    {
        return $this->render('electeurs/index.html.twig', [
            'controller_name' => 'ElecteursController',
        ]);
    }
}
