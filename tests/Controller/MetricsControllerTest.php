<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MetricsControllerTest extends WebTestCase
{
    public function testMetrics()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/metrics');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Introduktion');
    }
}

