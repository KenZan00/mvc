<?php

namespace App\Controller;

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

    #[Route('/proj/blackjack', name: 'blackjack')]
    public function blackJack(): Response
    {
        
        return $this->render('blackjack/blackjack.html.twig');
    }

    #[Route('/proj/rules', name: 'rules')]
    public function blackJackRules(): Response
    {
        return $this->render('blackjack/rules.html.twig');
    }

    #[Route('/proj/rules', name: 'proj_about')]
    public function projAbout(): Response
    {
        return $this->render('blackjack/about.html.twig');
    }
}
