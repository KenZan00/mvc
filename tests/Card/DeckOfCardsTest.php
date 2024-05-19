<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DeckOfCardsTest extends TestCase
{
    public function testSetupDeck()
    {    
        $deck = new DeckOfCards();
        $deck->setupDeck();
        $deckOfCards = $deck->getDeck();

        $this->assertCount(52, $deckOfCards);

        foreach ($deckOfCards as $testCard) {
            $this->assertInstanceOf(Card::class, $testCard);
        }

        
    }

    public function testSetupDeckText()
    {    
        $deck = new DeckOfCards();
        $deck->setupDeckText();
        $deckOfCards = $deck->getDeck();

        $this->assertCount(52, $deckOfCards);

        foreach ($deckOfCards as $testCard) {
            $this->assertInstanceOf(Card::class, $testCard);
        }

        
    }

    public function testSetValue()
    {
        $deck = new DeckOfCards();
        $deck->setupDeck();
        $deckOfCards = $deck->getDeck();

        foreach ($deckOfCards as $testCard) {
            
            $value = $testCard->getValue();
            $rank = $testCard->getRank();

            if (is_numeric($rank)) {
                $this->assertEquals($testCard->getRank(), $value);
            } else {
            switch($rank) {
                case 'Ace':
                    $this->assertEquals(14, $value);
                    break;           
                case 'King':
                    $this->assertEquals(13, $value);
                    break;
                case 'Queen':
                    $this->assertEquals(12, $value);
                    break;
                case 'Jack':
                    $this->assertEquals(11, $value);
                    break;
                default:
                    $this->assertEquals(0, $value);  
                }                 
                
            }

        }

    }

    public function testSetValueZeroValidation()
    {   
        $rank = 'Joker';
        $deck = new DeckOfCards;

        $cardValue = $deck->setValue($rank);
        $this->assertEquals(0, $cardValue);
    }

    public function testDrawCard()
    {    
        $deck = new DeckOfCards();
        $deck->setupDeck();

        $cards = $deck->draw(3);
        $leftInDeck = $deck->getDeck();

        $this->assertCount(3, $cards);
        $this->assertCount(49, $leftInDeck);

        foreach ($cards as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }        
    }

    public function testShuffleMethod()
    {    
        $deck = new DeckOfCards();
        $deck->setupDeck();

        $UnshuffledDeck = $deck->getDeck();
        $deck->shuffle();
        $shuffledDeck = $deck->getDeck();
        
        $this->assertNotEquals($UnshuffledDeck, $shuffledDeck);       
    }

    public function testCountCardsInDeck()
    {    
        $deck = new DeckOfCards();
        $deck->setupDeck();

        $count = $deck->countCards();

        $this->assertEquals(52, $count);       
    }

    public function testGetString ()
    {
        $deck = new DeckOfCards();
        $deck->setupDeck();
        
        $cardsInString = $deck->getString();
        
        $this->assertIsArray($cardsInString);
        $this->assertIsString($cardsInString[0]);
        $this->assertEquals('Ace ♠', $cardsInString[0]);
    }
}

