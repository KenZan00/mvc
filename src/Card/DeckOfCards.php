<?php

namespace App\Card;

use App\Card\Card;

/**
 * Class DeckOfCards
 * 
 * A class that holds and initializes a deck of cards
 * 
 * @package App\Card
 */

class DeckOfCards
{   
    /**
     * @var array<Card>
     */
    private array $deck = [];

    /**
     * Method that populates $deck[] with a full deck of Cards as graphical representation 
     */
    public function setupDeck(): void
    {
        /** @var array Array of all ranks in standard card deck */
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        /** @var array Array of all suits in standard card deck */
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $value = $this->setValue($rank);
                $this->deck[] = new CardGraphic($rank, $suit, $value);
            }
        }
    }

    /**
     * Method that populates $deck[] with a full deck of Cards as a textual representation 
     */
    public function setupDeckText(): void
    {
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $value = $this->setValue($rank);
                $this->deck[] = new Card($rank, $suit, $value);
            }
        }
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
    
    /**
     * Draw specified amount of cards from the top of deck
     * 
     * @param int $amount Number cards to draw
     * @return array<Card> Returns array of drawn cards
     */
    public function draw(int $amount): array
    {
        $drawnCards = [];

        for ($i = $amount; $i > 0 && !empty($this->deck); $i--) {
            $drawnCard = array_shift($this->deck);
            $drawnCards[] = $drawnCard;
        }
        return $drawnCards;
    }

    /**
     * Randomizing array in deck to simulate a shuffling
     */
    public function shuffle(): void
    {
        shuffle($this->deck);

    }

    /**
     * Counts the amount of cards currently in the deck
     * 
     * @return int Returns amount of cards left in deck as integer
     */
    public function countCards(): int
    {
        return count($this->deck);
    }

    /**
     * Get current deck of cards
     * 
     * @return array<Card> Array of card objects in deck
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
     * Retrieve string representations of cards in array
     * 
     * @return array<string>
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->deck as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }
}
