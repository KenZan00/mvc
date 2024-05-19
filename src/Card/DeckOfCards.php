<?php

namespace App\Card;

use App\Card\Card;

class DeckOfCards
{   
    /**
     * @var array<Card>
     */
    private array $deck = [];

    public function setupDeck(): void
    {
        $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
        $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];

        foreach ($suits as $suit) {
            foreach ($ranks as $rank) {
                $value = $this->setValue($rank);
                $this->deck[] = new CardGraphic($rank, $suit, $value);
            }
        }
    }

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

    public function shuffle(): void
    {
        shuffle($this->deck);

    }

    public function countCards(): int
    {
        return count($this->deck);
    }

    /**
     * @return array<Card>
     */
    public function getDeck(): array
    {
        return $this->deck;
    }

    /**
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
