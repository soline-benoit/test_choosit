<?php

namespace App\Command;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ProductExporter extends Command
{
    private $manager;

    public function __construct(EntityManagerInterface $manager)
    {
        $this->manager = $manager;
        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('export-all-products')
            ->setDescription("Export all products from database.")
            ->setHelp("This command allows you to export all products from database to CSV format.")
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        /** @var ProductRepository $productRep */
        $productRep = $this->manager->getRepository(Product::class);
        $products = $productRep->findAll();

        $handle = fopen('products.csv', 'w');

        foreach ($products as $product) {
            $arrayProducts = [
                "id" => $product->getId(),
                "name" => $product->getName(),
                "description" => $product->getDescription(),
                "price" => $product->getPrice(),
            ];

            fputcsv($handle, $arrayProducts);
        }

        fclose($handle);

        return 0;
    }
}