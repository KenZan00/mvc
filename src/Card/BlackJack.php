<?php

namespace App\Card;

use App\Card\DeckOfCards;
use App\Card\Player;
use App\Card\CardHand;

/**
 * Class BlackJack
 *
 * A class that game logic for BlackJack game
 *
 * @package App\Card
 */

class BlackJack {
    private DeckOfCards $deck;
    private Player $player;
    private Player $bank;

    public function __construct(DeckOfCards $deck, Player $player, Player $bank) {
        $this->deck = $deck;
        $this->player = $player;
        $this->bank = $bank;
    }

    public function getPlayer() {
        return $this->player;
    }

    public function getBank() {
        return $this->bank;
    }

    public function checkAceValue(CardHand $cards): int
    {
        $totValue = $cards->handValue();
        $aces = $cards->aces();

        while ($totValue > 21 && 0 < $aces) {
            $totValue -= 10;
            $aces--;
        }

        return (int)$totValue;
    }
    
}
