<?php

namespace App\Card;

use App\Card\DeckOfCards;
use App\Card\Player;
use App\Card\CardHand;

/**
 * Class BlackJack
 *
 * A class that game logic for BlackJack game
 *
 * @package App\Card
 */

class BlackJack
{
    /** @var DeckOfCards object containing Cards */
    private DeckOfCards $deck;

    /** @var Player object containing a Player */
    private Player $player;

    /** @var Player object containing a Player */
    private Player $bank;

    /**
     * Blackjack constructor.
     *
     * @param DeckOfCards $deck deckOfCards for gamelogic
     * @param Player $player Player as player object
     * @param Player $bank Bank as player objekt
     */
    public function __construct(DeckOfCards $deck, Player $player, Player $bank)
    {
        $this->deck = $deck;
        $this->player = $player;
        $this->bank = $bank;
    }

    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    public function getPlayer(): Player
    {
        return $this->player;
    }

    public function getBank(): Player
    {
        return $this->bank;
    }

    /**
     * Deal 1 card for bank
     * Deal 2 cards for player
     */
    public function deal(): void
    {
        $this->player->getHand()->addCardsArray($this->deck->draw(2));
        $this->bank->getHand()->addCardsArray($this->deck->draw(1));
    }

    /**
     * Draw cards for bank while handvalue is under 17 points
     *
     * @return int Return bankHandValue
     */
    public function bankDraw(): int
    {
        $bankHand = $this->bank->getHand();
        $bankHandValue = $this->checkAceValue($bankHand);

        while ($bankHandValue < 17) {
            $card = $this->deck->draw(1);
            $bankHand->addCardsArray($card);

            $bankHandValue = $this->checkAceValue($bankHand);
        }

        return $bankHandValue;
    }


    /**
     * Check value of CardHand and return adjusted value after calculating for aces
     *
     * @param CardHand $cards
     *
     * @return int Return hand value
     */
    public function checkAceValue(CardHand $cards): int
    {
        $totValue = $cards->handValue();
        $aces = $cards->aces();

        while ($totValue > 21 && 0 < $aces) {
            $totValue -= 10;
            $aces--;
        }

        return (int)$totValue;
    }

    /**
     * Decide winner of pot and set balance accordingly
     *
     * @param CardHand $playerCards The players hand.
     * @param CardHand $bankCards The banks hand.
     * @param int $bet The bet placed by player.
     *
     */
    public function money2Winner(CardHand $playerCards, CardHand $bankCards, int $bet): void
    {
        $playerValue = $this->checkAceValue($playerCards);
        $bankValue = $this->checkAceValue($bankCards);

        // Check if someone is bust
        if ($playerValue > 21) {
            $this->player->adjustChips(-$bet);
            $this->bank->adjustChips($bet);

        } elseif ($bankValue > 21) {
            $this->player->adjustChips($bet);
            $this->bank->adjustChips(-$bet);
            // Decide who gets the pot and retract from other
        } else {
            if ($playerValue > $bankValue) {
                $this->player->adjustChips($bet);
                $this->bank->adjustChips(-$bet);

            } elseif ($playerValue < $bankValue) {
                $this->player->adjustChips(-$bet);
                $this->bank->adjustChips($bet);
            }
        }
    }

    /**
     * Compare points to decide the winner of the game.
     *
     * @return string Returns the result of the winner.
     */
    public function comparePoints(): string
    {
        $bankTotal = $this->checkAceValue($this->bank->getHand());
        $playerTotal = $this->checkAceValue($this->player->getHand());

        $low = [17, 18, 19];
        $high = [20, 21];

        switch (true) {
            case $playerTotal > 21:
                return 'Bank Wins, Player get bust';
            case $bankTotal > 21:
                return 'Player Wins, Bank get bust';
            case $playerTotal < $bankTotal:
                return 'Bank Wins by points';
            case $playerTotal > $bankTotal:
                return 'Player wins by points';
            default:
                if ($playerTotal == $bankTotal && in_array($playerTotal, $low)) {
                    return 'Bank wins thru a tie in range 17-19';
                } elseif ($playerTotal == $bankTotal && in_array($playerTotal, $high)) {
                    return 'Bank wins through a tie in range 20-21';
                }

                return 'No winner';
        }

    }
}
