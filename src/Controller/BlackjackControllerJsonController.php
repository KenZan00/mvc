<?php

namespace App\Controller;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\BlackJackDeckCreator;
use App\Card\BlackJack;
use App\Card\Player;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlackjackControllerJsonController
{
    #[Route("/proj/api/deck", name:"blackjack_deck", methods: ["GET"])]
    public function deckApiProj(): Response
    {
        $cards = new BlackJackDeckCreator();
        $deck = $cards->setupDeck();
        $deck = new DeckOfCards($deck);

        $allCards = $deck->getString();

        $data = [
            'allCards' => $allCards,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    #[Route("/proj/api/shuffle", name:"blackjack_shuffle", methods: ["GET"])]
    public function shuffleApiProj(): Response
    {
        $cards = new BlackJackDeckCreator();
        $deck = $cards->setupDeck();
        $deck = new DeckOfCards($deck);
        $deck->shuffle();

        $allCards = $deck->getString();

        $data = [
            'shuffled cards' => $allCards,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    #[Route("/proj/api/player", name:"blackjack_player", methods: ["GET"])]
    public function playerApiProj(): Response
    {
        $card = new Card('Ace', 'Hearts', 11);
        $card2 = new Card('10', 'Spades', 10);

        $cardHand = new CardHand();
        $cardHand->add($card);
        $cardHand->add($card2);

        $player = new Player('Player  1', 5000, $cardHand);

        $data = [
            'name' => $player->getName(),
            'balance' => $player->getChips(),
            'hand' => $player->getHand()->getString(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    #[Route("/proj/api/blackjack", name:"blackjack_game", methods: ["GET"])]
    public function blackjackApiProj(
        SessionInterface $session
    ): Response {
        
        /** @var BlackJack $game */
        $game = $session->get("blackjack");

        if (!$game) {
            return new JsonResponse(['error' => 'Blackjack game not started'], Response::HTTP_NOT_FOUND);
        }

        $data = [
            'player name' => $game->getPlayer()->getName(),
            'player chips' => $game->getPlayer()->getChips(),
            'player hand' => $game->getPlayer()->getHand()->getString(),
            'bank' => $game->getBank()->getName(),
            'bank chips' => $game->getBank()->getChips(),
            'bank hand' => $game->getBank()->getHand()->getString(),
            'deck status' => $game->getDeck()->getString(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }

    #[Route("/proj/api/draw", name: "blackjack_draw", methods: ["POST"])]
    public function playerDraw(SessionInterface $session): Response
    {
        /** @var BlackJack $game */
        $game = $session->get("blackjack");

        if (!$game) {
            return new JsonResponse(['error' => 'Blackjack game not started'], Response::HTTP_NOT_FOUND);
        }

        $card = $game->getDeck()->draw(1);
        $game->getPlayer()->getHand()->add($card[0]);

        $session->set('blackjack', $game);
        // $card = $card[0]->getAsString();

        $data = [
            'player' => $game->getPlayer()->getPlayerString(),
            'drawn card' => $card[0]->getAsString(),
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE
        );
        return $response;
    }
}
