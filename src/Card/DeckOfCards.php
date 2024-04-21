<?php

namespace App\Card;

class DeckOfCards
{
    private $deck = [];


    public function getDeck(): array
    {
        return $this->deck;
    }

    public function initDeck()
    {
        $card = new Card();

        foreach ($card->getSuit() as $suit) {
            foreach($card->getRank() as $rank) {
                $this->deck[] = new Card($rank, $suit);
            }
        }
    }













    public function getNumberDices(): int
    {
        return count($this->hand);
    }

    public function getValues(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getValue();
        }
        return $values;
    }

    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $die) {
            $values[] = $die->getAsString();
        }
        return $values;
    }
}
