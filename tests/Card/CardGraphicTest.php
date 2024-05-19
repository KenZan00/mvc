<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardGraphicTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateGraphicCard(): void
    {
        $rank = 'Ace';
        $suit = '♦';
        $value = 14;

        $card = new CardGraphic($rank, $suit, $value);

        $this->assertInstanceOf("\App\Card\CardGraphic", $card);
        $this->assertInstanceOf(CardGraphic::class, $card);

        $testCard = new CardGraphic($rank, $suit, $value);

        $this->assertEquals($testCard, $card);

    }

    public function testGraphicCardAsString(): void
    {
        $rank = 'Ace';
        $suit = 'Diamonds';
        $value = 14;

        $card = new CardGraphic($rank, $suit, $value);

        $cardString = $card->getAsString();
        $teststring = 'Ace ♦';

        $this->assertEquals($cardString, $teststring);

    }
}
