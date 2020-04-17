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
use Symfony\Contracts\Translation\TranslatorInterface;

/**
 * @Route("/cart")
 */
class CartController extends AbstractController
{
    /**
     * @Route("/add/{slug}", name="add_to_cart_action")
     * @Route("/edit/{slug}", name="edit_quantity_action")
     * @Route("/remove/{slug}", name="remove_from_cart_action")
     * @Route("/product/remove/{slug}", name="details_remove_from_cart_action")
     * @param Request $request
     * @param Product $product
     * @param CartSession $cartSession
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     */
    public function editCartAction(Request $request, Product $product,
                                   CartSession $cartSession, TranslatorInterface $translator)
    {

        // choose flash message according to the action
        switch ($route = $request->get("_route")) {
            case 'edit_quantity_action':
                $flashMessage = $translator->trans('flashMessage.product.updated');
                break;
            case 'add_to_cart_action':
                $flashMessage = $translator->trans('flashMessage.product.added');
                break;
            default:
                $flashMessage = $translator->trans('flashMessage.product.removed');
                break;
        }

        $cartSession->addToCart($product, $request->get("quantity", 0));
        $this->addFlash("success", $flashMessage);

        // redirection to cart
        if ($route == "remove_from_cart_action") {
            return $this->redirectToRoute("show_cart");
        }

        // redirect to product details
        return $routeRedirection = $this->redirectToRoute("product_details", [
            "slug" => $product->getSlug()
        ]);
    }

    /**
     * @Route("/empty", name="empty_cart_action")
     * @param CartSession $cartSession
     * @param TranslatorInterface $translator
     * @return RedirectResponse
     */
    public function emptyCartAction(CartSession $cartSession, TranslatorInterface $translator)
    {
        $cartSession->emptyCart();

        $this->addFlash("success", $translator->trans('flashMessage.cart.emptied'));

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
            if ($infos["quantity"] > 0) {
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