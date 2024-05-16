<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreateCard()
    {   
        $rank = 'Ace';
        $suit = 'Diamonds';
        $value = '14';

        $card = new Card($rank, $suit, $value);

        $this->assertInstanceOf("\App\Card\Card", $card);
        $this->assertInstanceOf(Card::class, $card);

        $testCard = new Card($rank, $suit, $value);

        $this->assertEquals($testCard, $card);

    }

    public function testGetSuit()
    {
        $rank = 'Ace';
        $suit = 'Diamonds';
        $value = '14';

        $card = new Card($rank, $suit, $value);

        $cardSuit = $card->getSuit();

        $this->assertEquals($cardSuit, $suit);
    }

    public function testGetRank()
    {
        $rank = 'Ace';
        $suit = 'Diamonds';
        $value = '14';

        $card = new Card($rank, $suit, $value);

        $cardRank = $card->getRank();

        $this->assertEquals($cardRank, $rank);
    }

    public function testGetValue()
    {
        $rank = 'Ace';
        $suit = 'Diamonds';
        $value = '14';

        $card = new Card($rank, $suit, $value);

        $cardValue = $card->getValue();

        $this->assertEquals($cardValue, $value);
    }


    public function testGetAsString()
    {
        $rank = 'Ace';
        $suit = 'Diamonds';
        $value = '14';

        $card = new Card($rank, $suit, $value);

        $cardString = $card->getAsString();
        $teststring = 'Ace Diamonds';
        
        $this->assertEquals($cardString, $teststring);

    }
}
