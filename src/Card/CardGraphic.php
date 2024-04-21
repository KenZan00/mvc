<?php

namespace App\Card;

class CardGraphic extends Card
{
    private $representation = [
        'Spades' => '♠',
        'Hearts' => '♥',
        'Diamonds' => '♦',
        'Clubs' => '♣',
    ];

    public function __construct()
    {
        parent::__construct();
    }

    public function getAsString(): string
    {
        $rank = $this->getRank();
        $suit = $this->getSuit();

        $utf8 = array_search($suit, $this->representation);

        return "{$rank} {$utf8}";
    }

}
