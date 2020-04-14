<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $productData = [
            /* 01 */ [ "name" => "Livre", "price" => 10.0 ],
            /* 02 */ [ "name" => "Chaise", "price" => 20.0 ],
            /* 03 */ [ "name" => "Lampe", "price" => 15.5 ],
            /* 04 */ [ "name" => "T-shirt", "price" => 9.99 ],
            /* 05 */ [ "name" => "Pantalon", "price" => 22.99 ],
            /* 06 */ [ "name" => "Ordinateur", "price" => 1500.00 ],
            /* 07 */ [ "name" => "Télévision", "price" => 559.99 ],
            /* 08 */ [ "name" => "Canapé", "price" => 530.00 ],
            /* 09 */ [ "name" => "Bibliothèque", "price" => 100.0 ],
            /* 10 */ [ "name" => "Tapis", "price" => 30.0 ],
            /* 11 */ [ "name" => "Oreiller", "price" => 10.0 ],
            /* 12 */ [ "name" => "Micro-onde", "price" => 59.99 ],
        ];

        foreach ($productData as $data) {
            $product = new Product();
            $product->setName($data["name"]);
            $product->setDescription($faker->paragraph());
            $product->setPrice($data["price"]);
            $manager->persist($product);
        }

        $manager->flush();
    }
}