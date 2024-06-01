<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MetricsController extends AbstractController
{
    #[Route('/metrics', name: 'metrics')]
    public function index(): Response
    {
        return $this->render('metrics.html.twig');
    }
}
