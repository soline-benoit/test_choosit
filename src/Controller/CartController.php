<?php


namespace App\Controller;


use App\Entity\Product;
use App\Service\CartSession;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/add/{slug}", name="add_to_cart_action")
     * @param Request $request
     * @param Product $product
     * @param CartSession $cartSession
     * @return RedirectResponse
     */
    public function addToCartAction(Request $request, Product $product, CartSession $cartSession)
    {
        $cartSession->addToCart($product, $request->get("quantity"));

        $this->addFlash("success", "Le produit a été ajouté à votre panier");

        return $this->redirectToRoute("product_details", [
            "slug" => $product->getSlug()
        ]);
    }

    /**
     * @Route("/empty", name="empty_cart_action")
     * @param CartSession $cartSession
     * @return RedirectResponse
     */
    public function emptyCartAction(CartSession $cartSession)
    {
        $cartSession->emptyCart();

        $this->addFlash("success", "Le panier a été vidé");

        return $this->redirectToRoute("index");
    }
}