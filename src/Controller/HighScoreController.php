<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use App\Entity\HighScore;
use App\Repository\HighScoreRepository;
use Doctrine\Persistence\ManagerRegistry;

class HighScoreController extends AbstractController
{
    #[Route('/highscore', name: 'highscore_list')]
    public function index(
        HighScoreRepository $highScoreRepository
    ): Response {
        $score = $highScoreRepository
            ->highScore10();

        $data = [
            'score' => $score
        ];

        return $this->render('high_score/index.html.twig', $data);
    }


    #[Route('/highscore/create', name: 'highscore_create', methods: ['POST'])]
    public function createHighScore(
        ManagerRegistry $doctrine,
        SessionInterface $session
    ): Response {
        $entityManager = $doctrine->getManager();

        $playername = $session->get('playername');

        if ($playername) {
            $score = new HighScore();
            $score->setName($playername);
            $score->setScore(rand(1, 900));

            // tell Doctrine you want to (eventually) save the Product
            // (no queries yet)
            $entityManager->persist($score);

            // actually executes the queries (i.e. the INSERT query)
            $entityManager->flush();
        }

        return $this->redirectToRoute('highscore_list');
    }

    #[Route('/highscore/show', name: 'highscore_show_all')]
    public function showAllHighScore(
        HighScoreRepository $highScoreRepository
    ): Response {
        $score = $highScoreRepository
            ->findAll();

        // return $this->json($score);
        $response = $this->json($score);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
