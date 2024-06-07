<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;
use App\Card\BlackJack;

/**
 * Class BlackJack
 *
 * A class that game logic for BlackJack game
 *
 * @package App\Card
 */

 class Player {
    private $name;
    private $chips;
    private $hand;

    public function __construct($name, $chips, CardHand $hand) {
        $this->name = $name;
        $this->chips = $chips;
        $this->hand = $hand;
    }

}
