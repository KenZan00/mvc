<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Game21.
 */
class Game21Test extends TestCase
{
    public function test__constructor()
    {
        $bankHand = $this->createMock(CardHand::class);
        $playerHand = $this->createMock(CardHand::class);
        $deck = $this->createMock(DeckOfCards::class);

        // $stub = $this->createMock(Dice::class);

        $game = new Game21($deck, $playerHand, $bankHand);

        $this->assertEquals($deck, $game->getDeck());
        $this->assertEquals($playerHand, $game->getPlayerHand());
        $this->assertEquals($bankHand, $game->getBankHand());

    }
    
    public function testStart21()
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubHand = $this->createMock(CardHand::class);

        $stubDeck->expects($this->once())
        ->method('setupDeck');
        $stubDeck->expects($this->once())
        ->method('shuffle');
        $stubDeck->expects($this->once())
        ->method('draw');

        $stubHand->expects($this->once())
        ->method('addCardsArray');

        $game21 = new Game21($stubDeck, $stubHand, $stubHand);
        $game21->start21();
    }

    public function testBankDraw()
    {   
        $deck = new DeckOfCards();
        $deck->setupDeck();

        $playerHand = new CardHand();
        $bankHand = new CardHand();

        $game21 = new Game21($deck, $playerHand, $bankHand);

        $bankHandValue = $game21->bankDraw();

        $this->assertIsInt($bankHandValue);
        $this->assertGreaterThanOrEqual(17, $bankHandValue);
    }

    public function testCheckAceValue()
    {   
        $deck = new DeckOfCards();
        $deck->setupDeck();

        $cardHand = new CardHand();

        $card = new Card('Ace', 'Diamonds', 14);
        $card2 = new Card('10', 'Spades', 10);
        $card3 = new Card('10', 'Clubs', 10);
        
        $testCards = [$card, $card2, $card3];

        $cardHand = new CardHand();
        $cardHand->addCardsArray($testCards);

        $game21 = new Game21($deck, $cardHand, $cardHand);

        $valueChecker = $game21->checkAceValue($cardHand);

        $this->assertLessThanOrEqual(21, $valueChecker);

    }

    public function testComparePointsPlayerBust()
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubPlayer = $this->createMock(CardHand::class);

        $game21 = new game21($stubDeck, $stubPlayer, $stubBank);

        $stubPlayer->method('handValue')
                   ->willReturn(25);        
        $stubBank->method('handValue')
                 ->willReturn(17);

        $resultString = $game21->comparePoints();

        $this->assertEquals('Bank Wins, Player get bust', $resultString);
    }

    public function testComparePointsBankBust()
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubPlayer = $this->createMock(CardHand::class);

        $game21 = new game21($stubDeck, $stubPlayer, $stubBank);

        $stubPlayer->method('handValue')
                   ->willReturn(17);        
        $stubBank->method('handValue')
                 ->willReturn(25);

        $resultString = $game21->comparePoints();

        $this->assertEquals('Player Wins, Bank get bust', $resultString);
    }

    public function testComparePointsBankWinsByPoints()
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubPlayer = $this->createMock(CardHand::class);

        $game21 = new game21($stubDeck, $stubPlayer, $stubBank);

        $stubPlayer->method('handValue')
                   ->willReturn(20);        
        $stubBank->method('handValue')
                 ->willReturn(21);

        $resultString = $game21->comparePoints();

        $this->assertEquals('Bank Wins by points', $resultString);
    }

    public function testComparePointsPlayerWinsByPoints()
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubPlayer = $this->createMock(CardHand::class);

        $game21 = new game21($stubDeck, $stubPlayer, $stubBank);

        $stubPlayer->method('handValue')
                   ->willReturn(21);        
        $stubBank->method('handValue')
                 ->willReturn(20);

        $resultString = $game21->comparePoints();

        $this->assertEquals('Player wins by points', $resultString);
    }

    public function testComparePointsTie()
    {
        $stubDeck = $this->createMock(DeckOfCards::class);
        $stubBank = $this->createMock(CardHand::class);
        $stubPlayer = $this->createMock(CardHand::class);

        $game21 = new game21($stubDeck, $stubPlayer, $stubBank);

        $stubPlayer->method('handValue')
                   ->willReturn(21);        
        $stubBank->method('handValue')
                 ->willReturn(21);

        $resultString = $game21->comparePoints();

        $this->assertEquals('Bank wins thru a Tie', $resultString);
    }

}

