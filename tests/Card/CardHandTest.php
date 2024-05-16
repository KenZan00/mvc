<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class CardHandTest extends TestCase
{
    public function testCreateCardHand()
    {    
        // Create a stub for the Card class.
        $stub = $this->createMock(Card::class);

        // Configure the stub.
        $stub->method('getRank')
            ->willReturn('Ace');
        $stub->method('getSuit')
            ->willReturn('Diamonds');
        $stub->method('getValue')
            ->willReturn(14);

        $cardHand = new CardHand();

        $cardHand->add(clone $stub);

        $cards = $cardHand->getHand();

        foreach ($cards as $testCard) {
            $this->assertInstanceOf(Card::class, $testCard);
            $this->assertEquals('Ace', $testCard->getRank());
            $this->assertEquals('Diamonds', $testCard->getSuit());
            $this->assertEquals(14, $testCard->getValue());
            }
    }

    public function testAddCardHandThruArray()
    {    
        // Instantiate classes
        $card = new Card('Ace', 'Diamonds', 14);
        $card2 = new Card('Jack', 'Spades', 11);
        $card3 = new Card('10', 'Clubs', 10);
        
        $testCards = [$card, $card2, $card3];

        $cardHand = new CardHand();

        //Add and get cards
        $cardHand->addCardsArray($testCards);
        $getCardHand = $cardHand->getHand();
        
        //Assert single cards from array
        $this->assertEquals($card, $getCardHand[0]);
        $this->assertEquals($card2, $getCardHand[1]);
        $this->assertEquals($card3, $getCardHand[2]);

    }
   
    public function testHandValue()
    {
        $card = new Card('10', 'Clubs', 10);
        $cardHand = new CardHand();

        $cardHand->add($card);
        $cardHandValue = $cardHand->handValue();

        $this->assertEquals(10, $cardHandValue);
    }

    public function testGetNumCards ()
    {
        $card = new Card('10', 'Clubs', 10);
        $cardHand = new CardHand();

        $cardHand->add($card);
        // $numCards = $cardHand->getNumCards();
        
        $this->assertSame(1, $cardHand->getNumCards());
        $this->assertIsInt($cardHand->getNumCards());
    }

    public function testGetStringHand()
    {
        $card = new Card('10', 'Clubs', 10);
        $cardHand = new CardHand();

        $cardHand->add($card);
        $cardString = $cardHand->getString();

        $this->assertEquals('10 Clubs', $cardString[0]);
        $this->assertIsArray($cardString);
    }
    
    public function testAces()
    {
        $card = new Card('Ace', 'Diamonds', 14);
        $card2 = new Card('Ace', 'Spades', 14);
        $card3 = new Card('Ace', 'Clubs', 14);
        
        $testCards = [$card, $card2, $card3];

        $cardHand = new CardHand();

        //Add and get cards
        $cardHand->addCardsArray($testCards);

        $count = $cardHand->aces();
        
        $this->assertEquals(3, $count);
        $this->assertIsInt($count);
    }
}
