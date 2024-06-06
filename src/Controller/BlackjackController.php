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

    #[Route('/blackjack', name: 'blackjack')]
    public function blackJack(): Response
    {
        return $this->render('blackjack/blackjack.html.twig');
    }
}
