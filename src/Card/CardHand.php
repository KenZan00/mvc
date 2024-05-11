<?php

namespace App\Card;

use App\Card\Card;

class CardHand
{   
    /**
     * @var array<Card>
     */
    private array $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * @param array<Card> $cards
     * @return void
     */
    public function addCardsArray(array $cards): void
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

    /**
     * @return array<Card>
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    public function getNumCards(): int
    {
        return count($this->hand);
    }

    /**
     * @return array<string>
     */
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
