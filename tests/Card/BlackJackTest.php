<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * Test cases for class BlackJack.
 */
class BlackJackTest extends TestCase
{
    public function test__constructor(): void
    {
        $bank = $this->createMock(Player::class);
        $player = $this->createMock(Player::class);
        $deck = $this->createMock(DeckOfCards::class);

        // $stub = $this->createMock(Dice::class);

        $game = new BlackJack($deck, $player, $bank);

        $this->assertEquals($deck, $game->getDeck());
        $this->assertEquals($player, $game->getPlayer());
        $this->assertEquals($bank, $game->getBank());

    }

    public function testDeal(): void
    {
        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $player = new Player('Kenny', 1000, new CardHand());
        $bank = new Player('Bank', 9000, new CardHand());

        $blackjack = new BlackJack($deck, $player, $bank);

        $blackjack->deal();

        $this->assertCount(2, $player->getHand()->getHand());
        $this->assertCount(1, $bank->getHand()->getHand());
    }

    public function testBankDraw2(): void
    {
        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $player = new Player('Kenny', 1000, new CardHand());
        $bank = new Player('Bank', 9000, new CardHand());

        $blackjack = new BlackJack($deck, $player, $bank);

        $bankHandValue = $blackjack->bankDraw();

        $this->assertIsInt($bankHandValue);
        $this->assertGreaterThanOrEqual(17, $bankHandValue);
    }

    public function testCheckAceValue2(): void
    {
        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $player = new Player('Kenny', 1000, new CardHand());
        $bank = new Player('Bank', 9000, new CardHand());

        $card = new Card('Ace', 'Diamonds', 11);
        $card2 = new Card('10', 'Spades', 10);
        $card3 = new Card('10', 'Clubs', 10);

        $testCards = [$card, $card2, $card3];

        $cardHand = new CardHand();
        $cardHand->addCardsArray($testCards);

        $blackjack = new BlackJack($deck, $player, $bank);

        $valueChecker = $blackjack->checkAceValue($cardHand);

        $this->assertLessThanOrEqual(21, $valueChecker);

    }

    public function testComparePointsPlayerBust2(): void
    {
        $player = new Player('Kenny', 1000, new CardHand());
        $player->getHand()->addCardsArray([
            new Card('King', 'Diamonds', 10),
            new Card('10', 'Spades', 10),
            new Card('10', 'Clubs', 10)
        ]);

        $bank = new Player('Bank', 9000, new CardHand());
        $bank->getHand()->addCardsArray([
            new Card('King', 'Diamonds', 10),
            new Card('10', 'Spades', 10)
        ]);

        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $blackjack = new BlackJack($deck, $player, $bank);

        $resultString = $blackjack->comparePoints();

        $this->assertEquals('Bank Wins, Player get bust', $resultString);
    }

    public function testComparePointsBankBust2(): void
    {
        $player = new Player('Kenny', 1000, new CardHand());
        $player->getHand()->addCardsArray([
            new Card('King', 'Diamonds', 10),
            new Card('10', 'Spades', 10)
        ]);

        $bank = new Player('Bank', 9000, new CardHand());
        $bank->getHand()->addCardsArray([
            new Card('King', 'Diamonds', 10),
            new Card('10', 'Spades', 10),
            new Card('10', 'Clubs', 10)
        ]);

        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $blackjack = new BlackJack($deck, $player, $bank);

        $resultString = $blackjack->comparePoints();

        $this->assertEquals('Player Wins, Bank get bust', $resultString);
    }

    public function testmoney2Winner(): void
    {
        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $player = new Player('Kenny', 1000, new CardHand());
        $bank = new Player('Bank', 9000, new CardHand());

        $blackjack = new BlackJack($deck, $player, $bank);

        $playerHand = new CardHand();
        $playerHand->addCardsArray([
            new Card('5', 'Diamonds', 5),
            new Card('10', 'Clubs', 10)
        ]);

        $bankHand = new CardHand();
        $bankHand->addCardsArray([
            new Card('King', 'Hearts', 10),
            new Card('Ace', 'Diamonds', 11)
        ]);

        $bet = 100;

        $blackjack->money2Winner($playerHand, $bankHand, $bet);

        $this->assertEquals(900, $player->getChips());
        $this->assertEquals(9100, $bank->getChips());
    }

    public function testmoney2Winner2(): void
    {
        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $player = new Player('Kenny', 1000, new CardHand());
        $bank = new Player('Bank', 9000, new CardHand());

        $blackjack = new BlackJack($deck, $player, $bank);

        $playerHand = new CardHand();
        $playerHand->addCardsArray([
            new Card('5', 'Diamonds', 5),
            new Card('10', 'Clubs', 10),
            new Card('10', 'Hearts', 10)
        ]);

        $bankHand = new CardHand();
        $bankHand->addCardsArray([
            new Card('King', 'Hearts', 10),
            new Card('Ace', 'Diamonds', 11)
        ]);

        $bet = 100;

        $blackjack->money2Winner($playerHand, $bankHand, $bet);

        $this->assertEquals(900, $player->getChips());
        $this->assertEquals(9100, $bank->getChips());
    }

    public function testmoney2Winner3(): void
    {
        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $player = new Player('Kenny', 1000, new CardHand());
        $bank = new Player('Bank', 9000, new CardHand());

        $blackjack = new BlackJack($deck, $player, $bank);

        $playerHand = new CardHand();
        $playerHand->addCardsArray([
            new Card('10', 'Diamonds', 10),
            new Card('10', 'Clubs', 10)
        ]);

        $bankHand = new CardHand();
        $bankHand->addCardsArray([
            new Card('King', 'Hearts', 10),
            new Card('5', 'Diamonds', 5)
        ]);

        $bet = 1000;

        $blackjack->money2Winner($playerHand, $bankHand, $bet);

        $this->assertEquals(2000, $player->getChips());
        $this->assertEquals(8000, $bank->getChips());
    }

    public function testmoney2Winner4(): void
    {
        $deckCreator = new BlackJackDeckCreator();
        $cards = $deckCreator->setupDeck();
        $deck = new DeckOfCards($cards);

        $player = new Player('Kenny', 1000, new CardHand());
        $bank = new Player('Bank', 9000, new CardHand());

        $blackjack = new BlackJack($deck, $player, $bank);

        $playerHand = new CardHand();
        $playerHand->addCardsArray([
            new Card('10', 'Diamonds', 10),
            new Card('10', 'Clubs', 10)
        ]);

        $bankHand = new CardHand();
        $bankHand->addCardsArray([
            new Card('King', 'Hearts', 10),
            new Card('5', 'Diamonds', 5),
            new Card('King', 'Diamonds', 10)
        ]);

        $bet = 1000;

        $blackjack->money2Winner($playerHand, $bankHand, $bet);

        $this->assertEquals(2000, $player->getChips());
        $this->assertEquals(8000, $bank->getChips());
    }
}
