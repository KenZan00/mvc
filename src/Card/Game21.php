<?php

namespace App\Card;

use App\Card\CardHand;
use App\Card\DeckOfCards;

/**
 * Class Game21
 *
 * Gamelogic for the game 21.
 *
 * @package App\Card
 */

class Game21
{
    /** @var DeckOfCards Deck of cards. */
    private DeckOfCards $deck;

    /** @var CardHand Players hand of cards. */
    private CardHand $player;

    /** @var CardHand Banks hand of cards. */
    private CardHand $bank;

    /**
     * Constructor Game21
     *
     * @param DeckOfCards $deck The deck of cards used in game21.
     * @param CardHand $player Players hand of cards in game21.
     * @param CardHand $bank Banks hand of cards in game21.
     */
    public function __construct(DeckOfCards $deck, CardHand $player, CardHand $bank)
    {
        $this->deck = $deck;
        $this->player = $player;
        $this->bank = $bank;
    }

    /** Get deck in play */
    public function getDeck(): DeckOfCards
    {
        return $this->deck;
    }

    /** Get players hand */
    public function getPlayerHand(): CardHand
    {
        return $this->player;
    }

    /** Get banks hand */
    public function getBankHand(): CardHand
    {
        return $this->bank;
    }

    /**
     * Start and initialize game21 by setting upp deck,
     * shuffling and dealing first card to player.     *
     */
    public function start21(): void
    {
        $this->deck->shuffle();

        $playersCard = $this->deck->draw(1);

        $this->player->addCardsArray($playersCard);
    }

    /**
     * Draw cards for bank while handvalue is under 17 points
     *
     * @return int Return bankHandValue
     */
    public function bankDraw(): int
    {
        $bankHandValue = $this->checkAceValue($this->bank);

        while ($bankHandValue < 17) {
            $card = $this->deck->draw(1);
            $this->bank->add($card[0]);

            $bankHandValue = $this->checkAceValue($this->bank);
        }

        return $bankHandValue;
    }

    /**
    * Controll the total hand value, adjust Aces value if hand get bust.
    *
    * @param CardHand $cards The hand of cards to check for aces.
    * @return int Returns the adjusted value (total value) of the CardHand as integer.
    */
    public function checkAceValue(CardHand $cards): int
    {
        $totValue = $cards->handValue();
        $aces = $cards->aces();

        while ($totValue > 21 && 0 < $aces) {
            $totValue -= 13;
            $aces--;
        }

        return (int)$totValue;
    }

    /**
     * Compare points to decide the winner of the game.
     *
     * @return string Returns the result of the winner.
     */
    public function comparePoints(): string
    {
        $bankTotal = $this->checkAceValue($this->bank);
        $playerTotal = $this->checkAceValue($this->player);

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
                return 'Bank wins thru a Tie';
        }
    }
}
