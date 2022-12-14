<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $ingredient = new Ingredient();
        $ingredient->setName('Ingredient #1')
                   ->setPrice(3.0);
        $manager->persist($ingredient);           

        $manager->flush();
    }
}
