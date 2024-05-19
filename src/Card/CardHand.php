<?php

namespace App\Card;

use App\Card\Card;

/**
 * Class CardHand
 * 
 * A class that holds a hand of Cards
 * 
 * @package App\Card
 */

class CardHand
{   
    /**
     * @var array<Card> Array containing Card
     */
    private array $hand = [];

    public function add(Card $card): void
    {
        $this->hand[] = $card;
    }

    /**
     * Add array of cards to CardHand
     * 
     * @param array<Card> Cards
     * @return void
     */
    public function addCardsArray(array $cards): void
    {
        foreach ($cards as $card) {
            $this->add($card);
        }
    }

    /**
     * Retrieve total value from the CardHand
     * 
     * @return int Hand value as integer
     */
    public function handValue(): int
    {
        $value = 0;
        foreach ($this->hand as $card) {
            $value += $card->getValue();
        }
        return (int)$value;
    }

    /**
     * Retrieve hand of cards
     * 
     * @return array<Card> Hand of cards
     */
    public function getHand(): array
    {
        return $this->hand;
    }

    /**
     * Retrieve the number of cards in hand
     * 
     * @return int Return number of cards in hand as integer
     */
    public function getNumCards(): int
    {
        return count($this->hand);
    }

    /**
     * Retrieve string representation of all the cards in hand
     * 
     * @return array<string> Returns string representation of the cards in hand as array
     */
    public function getString(): array
    {
        $values = [];
        foreach ($this->hand as $card) {
            $values[] = $card->getAsString();
        }
        return $values;
    }

    /**
     *  Method that counts the number of aces in hand
     * 
     *  @return int Returns number of aces in hand as integer
     */
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
