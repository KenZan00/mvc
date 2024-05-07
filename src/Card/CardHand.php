<?php

namespace App\Card;

use App\Card\Card;
use App\Card\DeckOfCards;
use App\Card\Game21;

class CardHand
{
    private $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    public function addCardsArray($cards)
    {
        foreach ($cards as $card) {
            $this->add($card);
        }
    }

    public function handValue(): int
    {
        $value = 0;
        foreach ($this->hand as $card) {
            $value += $card->getValue(); 
        }
        return (int)$value;
    } 

    public function getHand(): array
    {
        return $this->hand;
    }

    public function getNumCards(): int
    {
        return count($this->hand);
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    public function aces(): int
    {
        $aces = 0;
        foreach($this->hand as $card) {
            if ($card->getRank() === 'Ace') {
                $aces++;
            }
        }
        return $aces;
    }
}
