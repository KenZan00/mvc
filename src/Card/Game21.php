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

    public function checkAceValue(CardHand $cards): int
    {
        $totValue = $cards->handValue();
        $aces = $cards->aces();

        while ($totValue > 21 && 0 < $aces) {
            $totValue -= 13;
            $aces--;
        }
        
        return (int)$totValue;
    }

}
