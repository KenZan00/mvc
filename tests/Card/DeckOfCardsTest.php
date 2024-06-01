<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class Dice.
 */
class DeckOfCardsTest extends TestCase
{
    public function testSetupDeck(): void
    {
        $deckCreator = new Deck21Creator();
        $cards = $deckCreator->setupDeck();

        $deck = new DeckOfCards($cards);

        $deckOfCards = $deck->getDeck();

        $this->assertCount(52, $deckOfCards);

        foreach ($deckOfCards as $testCard) {
            $this->assertInstanceOf(Card::class, $testCard);
        }


    }

    public function testSetValue(): void
    {
        $deckCreator = new Deck21Creator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);
        $deckOfCards = $deck->getDeck();

        foreach ($deckOfCards as $testCard) {
            $value = $testCard->getValue();
            $rank = $testCard->getRank();
            $expectedValue = $this->getTestValue($rank);

            $this->assertEquals($expectedValue, $value);
        }
    }

    private function getTestValue(string $rank): int
    {
        if (is_numeric($rank)) {
            return (int)$rank;
        }

        if ($rank === 'Ace') {
            return 14;
        }

        if ($rank === 'Jack') {
            return 11;
        }

        if ($rank === 'Queen') {
            return 12;
        }

        if ($rank === 'King') {
            return 13;
        }

        return 0;
    }

    public function testSetValueZeroValidation(): void
    {
        $rank = 'Joker';

        $deckCreator = new Deck21Creator();
        $cards = $deckCreator->setupDeck();

        new DeckOfCards($cards);

        $cardValue = $deckCreator->setValue($rank);
        $this->assertEquals(0, $cardValue);
    }

    public function testDrawCard(): void
    {
        $deckCreator = new Deck21Creator();
        $cards = $deckCreator->setupDeck();

        $deck = new DeckOfCards($cards);

        $cards = $deck->draw(3);
        $leftInDeck = $deck->getDeck();

        $this->assertCount(3, $cards);
        $this->assertCount(49, $leftInDeck);

        foreach ($cards as $card) {
            $this->assertInstanceOf(Card::class, $card);
        }
    }

    public function testShuffleMethod(): void
    {
        $deckCreator = new Deck21Creator();
        $cards = $deckCreator->setupDeck();

        $deck = new DeckOfCards($cards);

        $UnshuffledDeck = $deck->getDeck();
        $deck->shuffle();
        $shuffledDeck = $deck->getDeck();

        $this->assertNotEquals($UnshuffledDeck, $shuffledDeck);
    }

    public function testCountCardsInDeck(): void
    {
        $deckCreator = new Deck21Creator();
        $cards = $deckCreator->setupDeck();

        $deck = new DeckOfCards($cards);

        $count = $deck->countCards();

        $this->assertEquals(52, $count);
    }

    public function testGetString(): void
    {
        $deckCreator = new Deck21Creator();
        $cards = $deckCreator->setupDeck();

        $deck = new DeckOfCards($cards);

        $cardsInString = $deck->getString();

        $this->assertIsArray($cardsInString);
        $this->assertIsString($cardsInString[0]);
        $this->assertEquals('Ace ♠', $cardsInString[0]);
    }
}
