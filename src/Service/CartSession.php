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
        return array_sum(array_column($this->getCart(), 'quantity'));
    }

    /**
     * @return float
     */
    public function getTotalPrice(): float
    {
        $totalPrice = 0;
        foreach ($this->getCart() as $slug => $infos) {
            if ($infos['quantity'] > 0) {
                $totalPrice += $infos['quantity'] * $infos['price'];
            }
        }

        return $totalPrice;
    }

    /**
     * @param Product $product
     * @return int
     */
    public function getQuantityByProduct(Product $product): int
    {
        $cart = $this->getCart();
        if (array_key_exists($product->getSlug(), $cart)) {
            return $cart[$product->getSlug()]["quantity"];
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
        $cart[$product->getSlug()] = [
            "quantity" => $quantity,
            "price" => $product->getPrice(),
        ];
        $this->session->set("cart", $cart);
    }

    public function emptyCart()
    {
        $this->session->set("cart", []);
    }
}