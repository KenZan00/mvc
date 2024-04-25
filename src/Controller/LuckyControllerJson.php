<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
        $data = [
            "Det omöjliga tar bara lite längre tid - Sir Winston Churchill",
            "Förnuftet är en tjänare, intuitionen är en gåva – Einstein",
            "Det finns inget försöka, det finns bara göra eller inte göra – Yoda"

            // Add more routes as needed
        ];

        $randomDataIndex = array_rand($data);
        $randomData = $data[$randomDataIndex];


        $response = new JsonResponse($randomData);
        $response->setEncodingOptions(
            $response->getEncodingOptions() | JSON_PRETTY_PRINT
        );
        return $response;
    }
}
