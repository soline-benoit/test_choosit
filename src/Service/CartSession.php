<?php

namespace App\Service;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartSession
{
    private $cart;

    /**
     * CartSession constructor.
     * @param SessionInterface $session
     */
    public function __construct(SessionInterface $session)
    {
        $this->cart = $session->get("cart", []);
    }

    /**
     * @return array
     */
    public function getCart(): array
    {
        return $this->cart;
    }

    /**
     * @param Product $product
     * @param int $quantity
     */
    public function addToCart(Product $product, int $quantity)
    {
        if (array_key_exists($product->getId(), $this->cart)) {
            $oldQuantity = $this->cart[$product->getId()];
            $newQuantity = $oldQuantity + $quantity;
            $this->cart[$product->getId()] = $newQuantity;
        } else {
            $this->cart[$product->getId()] = $quantity;
        }
    }
}