<?php

namespace App\Card;

class Card
{
    protected string $rank;
    protected string $suit;
    protected int $value;

    public function __construct(string $rank, string $suit, int $value)
    {
        $this->rank = $rank;
        $this->suit = $suit;
        $this->value = $value;
    }

    public function getSuit(): string
    {
        return $this->suit;
    }

    public function getRank(): string
    {
        return $this->rank;
    }
    public function getValue(): int
    {
        return $this->value;
    }

    // Return as string
    public function getAsString(): string
    {
        return "{$this->rank} {$this->suit}";
    }
}
