<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class PlayerTest extends TestCase
{
    /**
     * Construct object and verify that the object has the expected
     * properties, use no arguments.
     */
    public function testCreatePlayer(): void
    {
        $name = 'John';
        $suit = '10000';
        $hand = new CardHand;

        $player = new Player($name, $suit, $hand);

        $this->assertInstanceOf("\App\Card\Player", $player);
        $this->assertInstanceOf(Player::class, $player);
    }

    public function testGetPlayerName()
    {
        $hand = new CardHand;

        $player = new Player('Kenny', 100, $hand);

        $this->assertEquals('Kenny', $player->getName());
    }

    public function testGetPlayerChips()
    {
        $hand = new CardHand;

        $player = new Player('Zelda', 200, $hand);

        $this->assertEquals(200, $player->getChips());
    }

    public function testAdjustChips()
    {
        $hand = new CardHand;
        $player = new Player('Zelda', 100, $hand);

        $player->adjustChips(50);

        $this->assertEquals(150, $player->getChips());
    }

    public function testPlayerSetBet()
    {
        $hand = new CardHand;
        $player = new Player('Zelda', 100, $hand);

        $player->setBet(100);

        $this->assertEquals(100, $player->getBet());
    }

    public function testPlayerGetHand()
    {   
        $card = new Card('Ace', 'Diamonds', 14);
        $card2 = new Card('Jack', 'Spades', 11);
        $card3 = new Card('10', 'Clubs', 10);

        $testCards = [$card, $card2, $card3];

        $cardHand = new CardHand();

        //Add and get cards
        $cardHand->addCardsArray($testCards);

        $player = new Player('Zelda', 100, $cardHand);

        $this->assertCount(3, $player->getHand()->getHand());
    }
    
    public function testPlayerGetAsString()
    {
        $card = new Card('Ace', 'Diamonds', 14);
        $card2 = new Card('Jack', 'Spades', 11);

        $testCards = [$card, $card2];

        $cardHand = new CardHand();

        //Add and get cards
        $cardHand->addCardsArray($testCards);

        $player = new Player('Zelda', 100, $cardHand);

        $playerMapp = [
            'name' => 'Zelda',
            'chips' => 100,
            'hand' => ['Ace Diamonds', 'Jack Spades']
        ];

        $this->assertEquals($playerMapp, $player->getPlayerString());
    }


}
