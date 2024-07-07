<?php

// src/Controller/ThemeController.php

namespace App\Controller;

use App\Entity\Theme;
use App\Form\ThemeFormType;
use Doctrine\ORM\EntityManagerInterface;
use PDO;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ThemeController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    private PDO $pdo;

    public function __construct(EntityManagerInterface $entityManager, PDO $pdo)
    {
        $this->entityManager = $entityManager;
        $this->pdo = $pdo;
    }

    #[Route('/', name: 'all_theme')]
    public function index(): Response
    {
        // récupère tous les thèmes depuis la base de données
        $stmt = $this->pdo->query('SELECT * FROM theme');
        $themes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $this->render('theme/all_theme.html.twig', [
            'themes' => $themes,
        ]);
    }

    #[Route('/theme', name: 'theme_crea')]
    public function themeCreate(Request $request): Response
    {
        // ajout du formulaire pour créer les thèmes
        $theme = new Theme();
        $form = $this->createForm(ThemeFormType::class, $theme);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // enregistrement du thème dans la base de donnée
            $this->entityManager->persist($theme);

            foreach ($theme->getProposition() as $proposition) {
                $this->entityManager->persist($proposition);
            }

            $this->entityManager->flush();

            // redirige vers la page détail du thème qui vient d'être crée
            return $this->redirectToRoute('theme_id', ['id' => $theme->getId()]);
        }

        return $this->render('theme/index.html.twig', [
            'controller_name' => 'ThemeController',
            'themeForm' => $form->createView()
        ]);
    }

    #[Route('/theme/{id}', name: 'theme_id')]
    public function theme(Theme $theme): Response
    {
        // affichage des détails d'un thème spécifique
        return $this->render('theme/theme_id.html.twig', [
            'controller_name' => 'ThemeController',
            'theme' => $theme,
        ]);
    }

    #[Route('/theme/{id}/handle_selection', name: 'handle_selection', methods: ['POST'])]
    public function handleSelection(Request $request, Theme $theme): Response
    {
        // récupération des propositions du thème
        $propositions = $theme->getProposition();

        $formData = $request->request->get('proposition_form');

        $selectedPropositions = [];
        foreach ($formData as $key => $value) {
            // extraire l'id de la proposition à partir du nom du champ qui a été séléctionné
            $propositionId = substr($key, strlen('proposition_form_top_'));

            // recherche de la proposition par son ID
            $proposition = $propositions->filter(function($prop) use ($propositionId) {
                return $prop->getId() == $propositionId;
            })->first();

            if (!$proposition) {
                throw new \RuntimeException('Proposition non trouvée pour l\'ID ' . $propositionId);
            }

            // ajouter la proposition sélectionnée à la liste des propositions choisies par l'utilisateur
            $selectedPropositions[] = [
                'id' => $proposition->getId(),
                'nom' => $proposition->getNom(),
            ];
        }

        return $this->json($selectedPropositions);
    }


    #[Route('/theme/{id}/vote', name: 'vote_theme')]
    public function vote(Theme $theme): Response
    {
        // affichage de tous les votes soumis pour un thème spécifique
        return $this->render('vote/index.html.twig', [
            'theme' => $theme,
        ]);
    }
}
