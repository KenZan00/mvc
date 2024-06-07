<?php

namespace App\Card;

use App\Card\DeckOfCards;
use App\Card\PLayer;

/**
 * Class BlackJack
 *
 * A class that game logic for BlackJack game
 *
 * @package App\Card
 */

class BlackJack {
    private $deck;
    private $player;
    private $bank;

    public function __construct(DeckOfCards $deck, Player $player, Player $bank) {
        $this->deck = $deck;
        $this->player = $player;
        $this->bank = $bank;
    }

    
}
