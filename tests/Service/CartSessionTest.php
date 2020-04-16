<?php

namespace App\Tests\Service;

use App\Entity\Product;
use App\Service\CartSession;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage;

class CartSessionTest extends TestCase
{
    public function testTotalQuantity()
    {
        $product = new Product();
        $product->setSlug("produit-test");
        $product->setPrice(10);

        $session = new Session(new MockArraySessionStorage());
        $cartSession = new CartSession($session);

        $cartSession->addToCart($product, 2);

        $this->assertEquals(2, $cartSession->getTotalQuantity());
    }

    public function testTotalQuantityEmptyCart()
    {
        $product = new Product();
        $product->setSlug("produit-test");

        $session = new Session(new MockArraySessionStorage());
        $cartSession = new CartSession($session);

        $cartSession->addToCart($product, 2);
        $cartSession->emptyCart();

        $this->assertEquals(0, $cartSession->getTotalQuantity());
    }

    public function testTotalPrice()
    {
        $product = new Product();
        $product->setSlug("produit-test");
        $product->setPrice(10);

        $session = new Session(new MockArraySessionStorage());
        $cartSession = new CartSession($session);

        $cartSession->addToCart($product, 2);

        $this->assertEquals(20, $cartSession->getTotalPrice());
    }

    public function testQuantityByProduct()
    {
        $product = new Product();
        $product->setSlug("produit-test");

        $session = new Session(new MockArraySessionStorage());
        $cartSession = new CartSession($session);

        $cartSession->addToCart($product, 2);

        $this->assertEquals(2, $cartSession->getQuantityByProduct($product));
    }
}