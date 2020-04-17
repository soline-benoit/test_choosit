<?php

namespace App\DataFixtures;

use App\Entity\Product;
use DateTime;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create('fr_FR');

        $productData = [
            [ "name" => "Livre", "price" => 10.0],
            [ "name" => "Chaise", "price" => 20.0 ],
            [ "name" => "Lampe", "price" => 15.5 ],
            [ "name" => "T-shirt", "price" => 9.99 ],
            [ "name" => "Pantalon", "price" => 22.99 ],
            [ "name" => "Ordinateur portable", "price" => 1500.00 ],
            [ "name" => "Télévision", "price" => 559.99 ],
            [ "name" => "Canapé", "price" => 530.00 ],
            [ "name" => "Bibliothèque", "price" => 100.0 ],
            [ "name" => "Tapis", "price" => 30.0 ],
            [ "name" => "Oreiller", "price" => 10.0 ],
            [ "name" => "Micro-onde", "price" => 59.99 ],
        ];

        foreach ($productData as $data) {
            $product = new Product();

            $product->setName($data["name"]);
            $product->setDescription($faker->paragraph());
            $product->setPrice($data["price"]);
            $product->setUpdatedAt(new DateTime("now"));
            $product->setImage("");
            $manager->persist($product);
            $manager->flush();

            $product->setImage($product->getSlug() . ".jpg");
            $manager->persist($product);
            $manager->flush();
        }
    }
}