<?php

namespace App\Controller;

use App\Card\DeckOfCards;
use App\Card\CardHand;
use App\Card\BlackJackDeckCreator;
use App\Card\BlackJack;
use App\Card\Player;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class BlackjackController extends AbstractController
{
    #[Route('/proj', name: 'proj')]
    public function projIndex(): Response
    {
        return $this->render('blackjack/index.html.twig');
    }

    #[Route('/proj/blackjack', name: 'blackjack', methods: ['GET'] )]
    public function blackJack(
        SessionInterface $session
    ): Response
    {
        
        return $this->render('blackjack/blackjack.html.twig');
    }

    #[Route('/proj/blackjack', name: 'blackjack_post', methods: ['POST'])]
    public function blackJackCallback(
        SessionInterface $session
    ): Response
    {   
        $cards = new BlackJackDeckCreator();
        $deck = $cards->setupDeck();
        $deck = new DeckOfCards($deck);

        $playerhand = new CardHand();
        $bankhand = new CardHand();

        $player = new Player('Player1', 1000, $playerhand);
        $bank = new Player('Dealer', 9000, $bankhand);

        $game = new blackJack($deck, $player, $bank);

        $session->set('blackjack', $game);

        
        return $this->redirectToRoute('play');
    }

    #[Route('/proj/blackjack/play', name: 'play', methods: ['GET'] )]
    public function blackJackPlay(
        SessionInterface $session
    ): Response
    {
        $game = $session->get("blackjack");

        if($game !== null) {
            $playerHand = $game->getPlayer()->getHand();
            $bankHand = $game->getBank()->getHand();
        
            // $playerAdjusted = $game->checkAceValue($playerHand);
            // $bankAdjusted = $game->checkAceValue($bankHand);

            // $data = [
            //     "playerHand" => $playerHand->getString(),
            //     "playerValue" => $playerAdjusted,
            //     "bankHand" => $bankHand->getString(),
            //     "bankValue" => $bankAdjusted
            // ];
        }
        
        return $this->render('blackjack/play.html.twig');
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
}
