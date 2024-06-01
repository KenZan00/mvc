<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TheGame21ControllerTest extends WebTestCase
{
    public function testGame21(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game');

        $this->assertResponseStatusCodeSame(200);

    }

    public function testGame21Callback(): void
    {
        $client = static::createClient();
        $client->request('POST', '/game');

        $this->assertResponseStatusCodeSame(302);

    }

    public function testGame21Round(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/round');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();

    }

    public function testGame21RoundPost(): void
    {
        $client = static::createClient();
        $client->request('POST', '/game/round');

        $this->assertResponseRedirects('/game/round');

    }

    public function testGame21StopPost(): void
    {
        $client = static::createClient();
        $client->request('POST', '/game/stop');

        // $this->assertResponseStatusCodeSame(302);
        $this->assertResponseRedirects('/game/round');

    }

    public function testGame21Restart(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/restart');

        $this->assertResponseRedirects('/game/round');
    }

    public function testGame21Doc(): void
    {
        $client = static::createClient();
        $client->request('GET', '/game/doc');

        $this->assertResponseStatusCodeSame(200);
        $this->assertResponseIsSuccessful();
    } 


}
