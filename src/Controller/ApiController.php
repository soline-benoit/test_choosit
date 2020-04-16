<?php


namespace App\Controller;


use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Service\CartSession;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/product/all", name="json_all_products")
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     */
    public function getAllProducts(EntityManagerInterface $manager)
    {
        /** @var ProductRepository $productRep */
        $productRep = $manager->getRepository(Product::class);
        $products = $productRep->findAll();

        $arrayProducts = [];
        foreach ($products as $product) {
            $arrayProducts[] = [
                "id" => $product->getId(),
                "name" => $product->getName(),
                "slug" => $product->getSlug(),
                "description" => $product->getDescription(),
                "price" => $product->getPrice(),
            ];
        }

        return new JsonResponse($arrayProducts);
    }

    /**
     * @Route("/product/{id}", name="json_product_by_id")
     * @param Product $product
     * @return JsonResponse
     */
    public function getProductById(Product $product)
    {
        $arrayProduct = [
            "id" => $product->getId(),
            "name" => $product->getName(),
            "slug" => $product->getSlug(),
            "description" => $product->getDescription(),
            "price" => $product->getPrice(),
        ];

        return new JsonResponse($arrayProduct);
    }

    /**
     * @Route("/cart", name="json_cart")
     * @param CartSession $cartSession
     * @param EntityManagerInterface $manager
     * @return JsonResponse
     */
    public function getCart(CartSession $cartSession, EntityManagerInterface $manager)
    {
        /** @var ProductRepository $productRep */
        $productRep = $manager->getRepository(Product::class);

        $arrayCart = [
            "totalQuantity" => $cartSession->getTotalQuantity(),
            "totalPrice" => $cartSession->getTotalPrice(),
            "products" => []
        ];

        foreach ($cartSession->getCart() as $slug => $infos) {
            $product = $productRep->findOneBy(["slug" => $slug]);
            $arrayCart["products"][] = [
                "id" => $product->getId(),
                "name" => $product->getName(),
                "slug" => $product->getSlug(),
                "description" => $product->getDescription(),
                "price" => $product->getPrice(),
                "quantity" => $infos["quantity"]
            ];
        }

        return new JsonResponse($arrayCart);
    }
}