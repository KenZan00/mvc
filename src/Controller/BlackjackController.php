<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\BlackJackDeckCreator;
use App\Card\BlackJack;
use App\Card\Player;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlackjackController extends AbstractController
{
    #[Route('/proj', name: 'proj')]
    public function projIndex(): Response
    {
        return $this->render('blackjack/index.html.twig');
    }

    #[Route('/proj/blackjack', name: 'blackjack', methods: ['GET'])]
    public function blackJack(
        SessionInterface $session
    ): Response {

        return $this->render('blackjack/blackjack.html.twig');
    }

    #[Route('/proj/blackjack', name: 'blackjack_post', methods: ['POST'])]
    public function blackJackCallback(
        SessionInterface $session,
        Request $request
    ): Response {
        $name = $request->request->get('playername');

        $cards = new BlackJackDeckCreator();
        $deck = $cards->setupDeck();
        $deck = new DeckOfCards($deck);
        $deck->shuffle();

        $playerhand = new CardHand();
        $bankhand = new CardHand();

        $player = new Player('Player1', 1000, $playerhand);
        $bank = new Player('Dealer', 9000, $bankhand);

        $game = new blackJack($deck, $player, $bank);
        $game->deal();

        $session->set('playername', $name);
        $session->set('blackjack', $game);


        return $this->redirectToRoute('play');
    }

    #[Route('/proj/blackjack/play', name: 'play', methods: ['GET'])]
    public function blackJackPlay(
        SessionInterface $session
    ): Response {
        $game = $session->get("blackjack");

        $data = [
            "playerHand" => '',
            "playerValue" => '',
            "bankHand" => '',
            "bankValue" => '',
            "playerMoney" => '',
            "bankMoney" => ''
        ];

        if($game !== null) {
            $playerHand = $game->getPlayer()->getHand();
            $bankHand = $game->getBank()->getHand();

            $playerValue = $game->checkAceValue($playerHand);
            $bankValue = $game->checkAceValue($bankHand);

            $data = [
                "playerHand" => $playerHand->getString(),
                "playerValue" => $playerValue,
                "bankHand" => $bankHand->getString(),
                "bankValue" => $bankValue,
                "playerMoney" => $game->getPlayer()->getChips(),
                "bankMoney" => $game->getBank()->getChips()
            ];
        }

        return $this->render('blackjack/play.html.twig', $data);
    }

    #[Route("/blackjack/play", name: "play_draw", methods: ['POST'])]
    public function blackJackDraw(
        SessionInterface $session
    ): Response {
        /** @var BlackJack $game */
        $game = $session->get("blackjack");

        if($game !== null) {
            $player = $game->getPlayer();
            $deck = $game->getDeck();

            $playerHand = $player->getHand();

            $card = $deck->draw(1);
            $playerHand->addCardsArray($card);

            $playerAdjusted = $game->checkAceValue($playerHand);

            if ($playerAdjusted > 21) {

                $this->addFlash(
                    'warning',
                    'You got bust and you lost the round!'
                );
            }
        }

        $session->set('blackjack', $game);

        return $this->redirectToRoute('play');
    }

    #[Route("/blackjack/stop", name: "play_stop", methods: ['POST'])]
    public function blackJackStop(
        SessionInterface $session
    ): Response {
        /** @var BlackJack $game */

        $game = $session->get("blackjack");
        $winner = null;

        if ($game !== null) {
            $game->bankDraw();
            $winner = $game->comparePoints();
        }

        if ($winner !== null) {
            $this->addFlash(
                'notice',
                $winner
            );
        }

        return $this->redirectToRoute('play');
    }

    #[Route("/blackjack/restart", name: "play_restart", methods: ['GET'])]
    public function restartGame(SessionInterface $session): Response
    {
        $session->remove("blackjack");
        $session->remove("playername");

        $cards = new BlackJackDeckCreator();
        $deck = $cards->setupDeck();
        $deck = new DeckOfCards($deck);
        $deck->shuffle();

        $playerhand = new CardHand();
        $bankhand = new CardHand();

        $player = new Player('Player1', 1000, $playerhand);
        $bank = new Player('Dealer', 9000, $bankhand);

        $game = new blackJack($deck, $player, $bank);

        $session->set('blackjack', $game);

        $session->set("game21_logic", $game);


        return $this->redirectToRoute('blackjack');
    }

    #[Route('/proj/rules', name: 'rules')]
    public function blackJackRules(): Response
    {
        return $this->render('blackjack/rules.html.twig');
    }

    #[Route('/proj/about', name: 'proj_about')]
    public function projAbout(): Response
    {
        return $this->render('blackjack/about.html.twig');
    }

    #[Route('/proj/api', name: 'api_blackjack')]
    public function projApiRoutes(): Response
    {
        $data = [
            'proj/api/deck' => 'Shows full deck of cards for Blackjack',
            'proj/api/shuffle' => 'Shows deck of cards shuffled',
            'proj/api/player' => 'Shows player example',
            'proj/api/blackjack' => 'Blackjack class example',
            'proj/api/player<name>' => 'Show book by ISBN'
        ];

        return $this->render('blackjack/api.html.twig', ['data' => $data]);
    }
}
