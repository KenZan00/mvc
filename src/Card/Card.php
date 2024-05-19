<?php

namespace App\Card;

/**
 * Class Card
 * 
 * A class that holds single play cards
 * 
 * @package App\Card
 */

class Card
{   
    /** @var string Rank of card */
    protected string $rank;

    /** @var string Suit of card */
    protected string $suit;

    /** @var int Value of card */
    protected int $value;

    /**
     * Card constructor.
     * 
     * @param string $rank Rank of cards example (A, 2, 3 - etc).
     * @param string $suit Suit of cards example ('Spades', 'Hearts').
     * @param int $value Value of cards as integer.
     */
    public function __construct(string $rank, string $suit, int $value)
    {
        $this->rank = $rank;
        $this->suit = $suit;
        $this->value = $value;
    }

    /**
     * Method to get Suit of Card
     * 
     * @return string Return suit of card
     */
    public function getSuit(): string
    {
        return $this->suit;
    }

    /**
     * Method to get Rank of Card
     * 
     * @return string Return rank of card
     */
    public function getRank(): string
    {
        return $this->rank;
    }

    /**
     * Method to get Value of Card
     * 
     * @return int Return Value of card
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * Method to get string representation of a Card object
     * 
     * @return string Return string representation of a Card object ex('10 Hearts')
     */
    public function getAsString(): string
    {
        return "{$this->rank} {$this->suit}";
    }
}
