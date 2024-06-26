<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\Deck21Creator;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameController extends AbstractController
{
    #[Route("/session", name: "card_session", methods: ['GET'])]
    public function session(
        SessionInterface $session
    ): Response {
        $session->get('card_deck');

        $data = [
            'session' => $session->all()
        ];

        return $this->render('card/session.html.twig', $data);
    }

    #[Route("/session/delete", name: "card_session_delete")]
    public function delete(
        SessionInterface $session
    ): Response {
        $session->clear();

        $this->addFlash(
            'notice',
            'Session destroyed!'
        );

        return $this->redirectToRoute('card_session');
    }

    #[Route("/card", name: "card_start")]
    public function home(
        SessionInterface $session
    ): Response {
        if (!$session->has('card_deck')) {
            $cards = new deck21Creator();
            $deck = $cards->setupDeck();

            $deck = new DeckOfCards($deck);
            $session->set("card_deck", $deck);
        }

        return $this->render('card/home.html.twig');
    }

    #[Route("/card/deck", name: "card_deck")]
    public function cardDeck(
    ): Response {
        $cards = new deck21Creator();
        $deck = $cards->setupDeck();

        $deck = new DeckOfCards($deck);

        $allCards = $deck->getString();

        $data = [
            'allCards' => $allCards,
        ];

        return $this->render('card/deck.html.twig', $data);
    }

    #[Route("/card/deck/shuffle", name: "card_shuffle")]
    public function cardShuffle(
        SessionInterface $session
    ): Response {
        $cards = new deck21Creator();
        $deck = $cards->setupDeck();

        $deck = new DeckOfCards($deck);
        $deck->shuffle();

        $session->set("card_deck", $deck);

        $allCards = $deck->getString();

        $data = [
            'allCards' => $allCards,
        ];

        return $this->render('card/deck/shuffle.html.twig', $data);
    }

    #[Route("/card/deck/draw", name: "card_draw", methods: ['GET'])]
    public function cardDraw(
        SessionInterface $session
    ): Response {
        $deck = $session->get('card_deck');
        $countCards = $deck->countCards();

        if ($countCards > 0) {
            $drawn = $deck->draw(1);

            $hand = new CardHand();
            $hand->addCardsArray($drawn);

            $cardsHand = $hand->getString();
        } else {

            $cardsHand = [];
        }

        $countCards = $deck->countCards();

        $data = [
            'hand' => $cardsHand,
            'countCards' => $countCards
        ];

        return $this->render('card/deck/draw.html.twig', $data);
    }

    #[Route("/card/deck/draw/{num<\d+>}", name: "card_draw_num")]
    public function cardDrawNum(
        int $num,
        SessionInterface $session,
    ): Response {
        {
            $deck = $session->get('card_deck');

            // $num = (int)$request->request->get('num', 1);


            $countCards = $deck->countCards();

            if ($countCards > 0) {
                $drawn = $deck->draw($num);

                $hand = new CardHand();
                $hand->addCardsArray($drawn);

                $cardsHand = $hand->getString();
            } else {

                $cardsHand = [];
            }

            $countCards = $deck->countCards();

            $data = [
                'hand' => $cardsHand,
                'countCards' => $countCards
            ];
        }

        return $this->render('card/deck/draw.html.twig', $data);
    }

    #[Route("/api", name: "api")]
    public function api(): Response
    {
        $datas = [
            '/api/deck => Full Deck of cards - sorted',
            'POST /api/shuffle => Full Deck of cards - shuffled',
            'POST /api/draw => Draw 1 card',
            'POST /api/draw/{num} => Draw {num} cards',
            'Use buttons to test POST'
        ];

        $data = [
            "data" => $datas
        ];

        return $this->render('api.html.twig', $data);
    }

}
