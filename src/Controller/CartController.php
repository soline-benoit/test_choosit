<?php


namespace App\Controller;


use App\Entity\Product;
use App\Service\CartSession;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/add/{slug}", name="add_to_cart_action")
     * @Route("/edit/{slug}", name="edit_quantity_action")
     * @Route("/remove/{slug}", name="remove_from_cart_action")
     * @param Request $request
     * @param Product $product
     * @param CartSession $cartSession
     * @return RedirectResponse
     */
    public function editCartAction(Request $request, Product $product, CartSession $cartSession)
    {
        switch ($request->get("_route")) {
            case 'edit_quantity_action':
                $flashMessage = "La quantité du produit a été modifiée";
                break;
            case 'remove_from_cart_action':
                $flashMessage = "Le produit a été retiré du panier";
                break;
            default:
                $flashMessage = "Le produit a été ajouté à votre panier";
                break;
        }

        $cartSession->addToCart($product, $request->get("quantity", 0));
        $this->addFlash("success", $flashMessage);

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

        return $this->redirectToRoute("show_cart");
    }

    /**
     * @Route("/show", name="show_cart")
     * @param CartSession $cartSession
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function showCart(CartSession $cartSession, EntityManagerInterface $manager)
    {
        $listItems = [];

        foreach ($cartSession->getCart() as $slug => $infos) {
            if ($infos > 0) {
                $productRep = $manager->getRepository(Product::class);

                $listItems[] = [
                    "product" => $productRep->findOneBy(["slug" => $slug]),
                    "quantity" => $infos["quantity"]
                ];
            }
        }

        return $this->render("cart/show.html.twig", [
            "listItems" => $listItems
        ]);
    }
}