<?php

namespace App\Controller;

use App\Entity\Theme;
use App\Form\PropositionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BulletinController extends AbstractController
{
    #[Route('/theme/{id}/bulletin', name: 'app_bulletin')]
    public function index(Theme $theme, Request $request): Response
    {
        // récupére toutes les propositions faites pour le thème
        $propositions = $theme->getProposition()->map(function($proposition) {
            return $proposition->getNom();
        })->toArray();

        // récupère le nombre de places gagnantes pour le thème
        $places = $theme->getNombrePlacesGagnantes();

        // ajout du formulaire pour faire son vote
        $form = $this->createForm(PropositionFormType::class, null, [
            'places' => $places,
            'propositions' => $propositions,
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $selectedPropositions = [];
            // pour chaque champ remplit, on regarde le placement pour faire le top
            for ($i = 1; $i <= $places; $i++) {
                $selectedPropositions['Top ' . $i] = $form->get('top_' . $i)->getData();
            }

            return $this->redirectToRoute('app_vote', [
                'id' => $theme->getId(),
                'selectedPropositions' => $selectedPropositions,
            ]);
        }

        return $this->render('bulletin/index.html.twig', [
            'controller_name' => 'BulletinController',
            'form' => $form->createView(),
            'theme' => $theme,
        ]);
    }
}
