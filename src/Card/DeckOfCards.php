<?php

namespace App\Card;

use App\Card\Card;

/**
 * Class DeckOfCards
 *
 * A class that holds a deck of cards injected from a "deck creator class"
 *
 * @package App\Card
 */

class DeckOfCards
{
    /** @var Card[] */
    private array $deck;

    /**
     * deckOfCards constructor.
     *
     * @param Card[] $cards Cards as array dependancy injected
     */
    public function __construct(array $cards)
    {
        $this->deck = $cards;
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
