<?php

namespace App\Card;

class Card
{
    protected $rank;
    protected $suit;
    protected $value;

    public function __construct($rank, $suit, $value)
    {
        $this->rank = $rank;
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getSuit()
    {
        return $this->suit;
    }

    public function getRank()
    {
        return $this->rank;
    }
    public function getValue()
    {
        return $this->rank;
    }

    // Return as string
    public function getAsString(): string
    {
        return "{$this->rank} {$this->suit}";
    }
}




// Läggas i deck istället ? Annan funktion ?
// public function draw()
// {
//     $randomRankIndex = array_rand($this->ranks);
//     $randomSuitIndex = array_rand($this->suits);

//     $this->rank = $this->ranks[$randomRankIndex];
//     $this->suit = $this->suits[$randomSuitIndex];

// }
