<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testRedirectionStatus()
    {
        $client = static::createClient();

        $client->request('GET', '/');

        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    public function testAfterRedirectionStatus()
    {
        $client = static::createClient();

        $client->request('GET', '/');
        $client->followRedirect();

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}