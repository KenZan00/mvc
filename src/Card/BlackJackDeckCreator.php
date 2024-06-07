<?php

namespace App\Card;

use App\Card\Card;

/**
 * Class BlackJackDeckCreator
 *
 * A class that initializes standard deck of cards for BlackJack
 *
 * @package App\Card
 */

class BlackJackDeckCreator
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
            return 11;
        }

        if (in_array($rank, ['Jack', 'Queen', 'King'])) {
            return 10;
        }

        return 0;
    }
}
