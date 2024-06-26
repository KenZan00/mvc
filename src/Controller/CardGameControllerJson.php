<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\Deck21Creator;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CardGameControllerJson
{
    #[Route("/api/deck")]
    public function deckApi(): Response
    {
        $cards = new deck21Creator();
        $deck = $cards->setupDeck();

        $deck = new DeckOfCards($deck);

        $allCards = $deck->getString();

        $data = [
            'allCards' => $allCards,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/shuffle", name:"shuffle", methods: ["POST"])]
    public function shuffleApi(
        SessionInterface $session,
    ): Response {
        $cards = new deck21Creator();
        $deck = $cards->setupDeck();

        $deck = new DeckOfCards($deck);
        $session->set("card_deck", $deck);

        $deck->shuffle();
        $shuffledDeck = $deck->getString();

        $data = [
            'allCards' => $shuffledDeck,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/deck/draw", name:"draw", methods: ["POST"])]
    public function drawApi(
        SessionInterface $session,
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

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    #[Route("/api/deck/draw/", name:"draw_num", methods: ["POST"])]
    public function drawNumApi(
        SessionInterface $session,
        Request $request,
    ): Response {
        $num = (int)$request->request->get('draw_num');

        $deck = $session->get('card_deck');
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

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }
}
