<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use DateTime;
use DateTimeZone;

class LuckyControllerJson
{
    #[Route("/api/lucky/number")]
    public function jsonNumber(): Response
    {
        $number = random_int(0, 100);

        $data = [
            'lucky-number' => $number,
            'lucky-message' => 'Hi there!',
        ];

        // return new JsonResponse($data);

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api")]
    public function api(): Response
    {

        $data = [
            '/api/lucky/number' => 'Get a lucky number',
            '/api/quote' => 'Get 1 of 3 random quotes'
        ];


        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }

    #[Route("/api/quote")]
    public function quote(): Response
    {
        // List of quotes directly in array
        $quotes = [
            'Nothing is impossible. The impossible just takes a little longer. Winston Churchill.',
            'The intuitive mind is a sacred gift and the rational mind is a faithful servant. Einstein',
            'There is no trying, there is only do or dont. Yoda'
        ];

        $randomDataIndex = array_rand($quotes);
        $randomQuote = $quotes[$randomDataIndex];
        
        // Correct date/time by zone
        $zone = new DateTimeZone('Europe/Stockholm');
        $dateTime = new DateTime('now', $zone);
        $date = $dateTime->format('Y-m-d');

        $time = $dateTime->format('H:i:s'); 

        $data = [
            'quote' => $randomQuote,
            'date' => $date,
            'time' => $time,
        ];

        $response = new JsonResponse($data);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
