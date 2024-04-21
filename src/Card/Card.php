<?php

namespace App\Card;

class Card
{
    protected $ranks = ['Ace', '2', '3', '4', '5', '6', '7', '8', '9', '10', 'Jack', 'Queen', 'King'];
    protected $suits = ['Spades', 'Hearts', 'Diamonds', 'Clubs'];

    protected $rank;
    protected $suit;

    public function __construct()
    {
        $this->rank = null;
        $this->suit = null;
    }

    public function draw()
    {
        $randomRankIndex = array_rand($this->ranks);
        $randomSuitIndex = array_rand($this->suits);

        $this->rank = $this->ranks[$randomRankIndex];
        $this->suit = $this->suits[$randomSuitIndex];

    }

    public function getSuit()
    {
        return $this->suits;
    }

    public function getRank()
    {
        return $this->ranks;
    }

    public function getAsString(): string
    {
        return "{$this->rank} of {$this->suit}";
    }
}
