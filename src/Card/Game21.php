<?php

namespace App\Card;

use App\Card\Card;
use App\Card\CardHand;
use App\Card\DeckOfCards;

class Game21
{
    private $deck;
    private $player;
    private $bank;

    public function __construct(DeckOfCards $deck, CardHand $player, CardHand $bank)
    {
        $this->deck = $deck;
        $this->player = $player;
        $this->bank = $bank;
    }

    public function start21()
    {
        $this->deck->setupDeck();
        $this->deck->shuffle();

        $playersCard = $this->deck->draw(1);

        $this->player->addCardsArray($playersCard);
    }

}
