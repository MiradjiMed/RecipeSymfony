<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $ingredient = new Ingredient();
        $ingredient->setName('Ingredient #1')
                   ->setPrice(3.0);

        $manager->flush();
    }
}
