<?php

namespace App\Card;

class CardGraphic extends Card
{   
    /**
    * @var array<string, string> $representation
    */
    private array $representation = [
        'Spades' => '♠',
        'Hearts' => '♥',
        'Diamonds' => '♦',
        'Clubs' => '♣',
    ];

    public function __construct(string $rank, string $suit, int $value)
    {
        parent::__construct($rank, $suit, $value);
    }

    public function getAsString(): string
    {
        $ranks = $this->getRank();
        $suits = $this->representation[$this->getSuit()];

        return "{$ranks} {$suits}";
    }

}
