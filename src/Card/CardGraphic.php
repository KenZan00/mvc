<?php

namespace App\Card;

class CardGraphic extends Card
{
    /**
    * @var string[] Representation of suits
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

    /**
    * @return string Cards as string
    */
    public function getAsString(): string
    {
        $ranks = $this->getRank();
        $suits = $this->representation[$this->getSuit()];

        return "{$ranks} {$suits}";
    }

}
