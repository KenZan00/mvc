<?php

namespace App\Card;

use App\Card\CardHand;

/**
 * Class BlackJack
 *
 * A class that game logic for BlackJack game
 *
 * @package App\Card
 */

class Player
{
    /** @var string name of player */
    private $name;

    /** @var int Number of chips left */
    private $chips;

    /** @var Cardhand of Card objects*/
    private CardHand $hand;

    /** @var int The number of chips bet*/
    private $bet;

    /**
     * Player constructor.
     *
     * @param string $name Name of the player.
     * @param int $chips The number of chips.
     * @param CardHand $hand The players cardhand.
     */
    public function __construct(string $name, int $chips, CardHand $hand)
    {
        $this->name = $name;
        $this->chips = $chips;
        $this->hand = $hand;
    }

    /**
     * Get players name
     *
     * @return string String of player name
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Get number of players chips left
     *
     * @return int Integer of player chips
     */
    public function getChips(): int
    {
        return $this->chips;
    }

    /**
     * Adjust chips method
     *
     * @param int Integer of the entered $bet
     */
    public function adjustChips(int $bet): void
    {
        $this->chips += $bet;
    }

    /**
     * Get number of players entered bet
     *
     * @return int Integer of players bet
     */
    public function getBet(): int
    {
        return (int) $this->bet;
    }

    /**
     * Set the amount from bet for the player.
     *
     * @param int $bet amount to set
     */
    public function setBet(int $bet): void
    {
        $this->bet = (int) $bet;
    }

    /**
     * Get players hand of cards.
     *
     * @return CardHand Players hand of cards.
     */
    public function getHand(): CardHand
    {
        return $this->hand;
    }

    /**
     * Get representation as string, of player.
     *
     * @return array<string,mixed> Array representing the players status (variables).
     */
    public function getPlayerString(): array
    {
        return [
            'name' => $this->name,
            'chips' => $this->chips,
            'hand' => $this->hand->getString()
        ];
    }

}
