<?php


namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class MainControllerTest extends WebTestCase
{
    public function testAfterRedirectionStatus()
    {
        $client = static::createClient();

        $client->request('GET', '/fr');
        $client->followRedirect(); // language redirection
        $client->followRedirect(); // products list redirection

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}