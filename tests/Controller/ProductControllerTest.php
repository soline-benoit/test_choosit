<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testShowListResponseStatus()
    {
        $client = static::createClient();

        $client->request('GET', '/fr/product/list');

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    public function testShowListNumberOfProducts()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/fr/product/list');

        $numberOfProductCards = $crawler->filter(".card")->count();

        $this->assertEquals(12, $numberOfProductCards);
    }
}