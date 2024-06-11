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

class Player
{
    private $name;
    private $chips;
    private CardHand $hand;
    private $bet;

    public function __construct($name, $chips, CardHand $hand)
    {
        $this->name = $name;
        $this->chips = $chips;
        $this->hand = $hand;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getChips(): string
    {
        return $this->chips;
    }

    public function adjustChips(int $bet): void
    {
        $this->chips += $bet;
    }

    public function getBet(): int
    {
        return $this->bet;
    }

    public function setBet(int $bet): void
    {
        $this->bet = $bet;
    }

    public function getHand(): CardHand
    {
        return $this->hand;
    }

    public function getPlayerString(): array
    {
        return [
            'name' => $this->name,
            'chips' => $this->chips,
            'hand' => $this->hand->getString()
        ];
    }


}
