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
        $fakerFr = Faker\Factory::create('fr_FR');
        $fakerEn = Faker\Factory::create('en_US');

        $productData = [
            [ "name" => ["fr" => "Livre", "en" => "Book"], "price" => 10.0],
            [ "name" => ["fr" => "Chaise", "en" => "Chair"], "price" => 20.0 ],
            [ "name" => ["fr" => "Lampe", "en" => "Lamp"], "price" => 15.5 ],
            [ "name" => ["fr" => "T-shirt", "en" => "T-shirt"], "price" => 9.99 ],
            [ "name" => ["fr" => "Pantalon", "en" => "Pants"], "price" => 22.99 ],
            [ "name" => ["fr" => "Ordinateur portable", "en" => "Laptop"], "price" => 1500.00 ],
            [ "name" => ["fr" => "Télévision", "en" => "Television"], "price" => 559.99 ],
            [ "name" => ["fr" => "Canapé", "en" => "Couch"], "price" => 530.00 ],
            [ "name" => ["fr" => "Bibliothèque", "en" => "Bookcase"], "price" => 100.0 ],
            [ "name" => ["fr" => "Tapis", "en" => "Carpet"], "price" => 30.0 ],
            [ "name" => ["fr" => "Oreiller", "en" => "Pillow"], "price" => 10.0 ],
            [ "name" => ["fr" => "Micro-onde", "en" => "Microwave"], "price" => 59.99 ],
        ];

        foreach ($productData as $data) {
            $product = new Product();

            $product->setName($data["name"]["fr"]);
            $product->setDescription($fakerFr->realText());
            $product->setPrice($data["price"]);
            $product->setUpdatedAt(new DateTime("now"));
            $product->setImage("");
            $manager->persist($product);
            $manager->flush();

            $product->setImage($product->getSlug() . ".jpg");
            $manager->persist($product);
            $manager->flush();

            $product->setTranslatableLocale('en');
            $product->setName($data["name"]["en"]);
            $product->setDescription($fakerEn->realText());
            $manager->persist($product);
            $manager->flush();
        }
    }
}