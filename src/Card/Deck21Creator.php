<?php

namespace App\Card;

use App\Card\Card;

class Deck21Creator
{
    /**
     * Method that populates a full deck of Cards as graphical representation.
     *
     * @return Card[]
     */
    public function setupDeck(): array
    {
        $deck = [];

        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $value = $this->setValue($rank);
                $deck[] = new CardGraphic($rank, $suit, $value);
            }
        }

        return $deck;
    }

    /**
     * Set Values of Cards during population of deck, based on its rank
     *
     * @param string $rank Takes the rank of card as argument
     * @return int Returns value for given card
     */
    public function setValue(string $rank): int
    {
        if (is_numeric($rank)) {
            return (int)$rank;
        }

        if ($rank === 'Ace') {
            return 14;
        }

        if ($rank === 'Jack') {
            return 11;
        }

        if ($rank === 'Queen') {
            return 12;
        }

        if ($rank === 'King') {
            return 13;
        }

        return 0;
    }
}
