<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/product")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/list", name="product_list")
     * @param EntityManagerInterface $manager
     * @return Response
     */
    public function showList(EntityManagerInterface $manager)
    {
        /** @var ProductRepository $productRep */
        $productRep = $manager->getRepository(Product::class);
        $products = $productRep->findBy([], ["name" => "ASC"]);

        return $this->render("product/list.html.twig", [
            "products" => $products
        ]);
    }

    /**
     * @Route("/{slug}", name="product_details")
     * @param Product $product
     * @return Response
     */
    public function showDetails(Product $product)
    {
        return $this->render("product/details.html.twig", [
            "product" => $product
        ]);
    }
}