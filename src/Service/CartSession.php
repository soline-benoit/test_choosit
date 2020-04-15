<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSession
{
    private $session;

    /**
     * CartSession constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return array
     */
    public function getCart(): array
    {
        return $this->session->get("cart", []);
    }

    /**
     * @return int
     */
    public function getTotalQuantity(): int
    {
        return array_sum($this->getCart());
    }

    /**
     * @param Product $product
     * @return int
     */
    public function getQuantityByProduct(Product $product): int
    {
        $cart = $this->getCart();
        if (array_key_exists($product->getSlug(), $cart)) {
            return $cart[$product->getSlug()];
        }

        return 0;
    }

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function addToCart(Product $product, int $quantity)
    {
        $cart = $this->getCart();
        $cart[$product->getSlug()] = $quantity;
        $this->session->set("cart", $cart);
    }

    public function emptyCart()
    {
        $this->session->set("cart", []);
    }
}