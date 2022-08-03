<?php

namespace App\DataFixtures;

use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\Factory;
use Generator;

class AppFixtures extends Fixture
{
    /**
    * @var Generator
    */
    private Generator $faker;
    
    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for($i = 1; $i <= 50; $i++) {
            // $product = new Product();
        // $manager->persist($product);
        $ingredient = new Ingredient();
        $ingredient->setName('Ingredient ' . $i)
                   ->setPrice(mt_rand(0, 100));
        $manager->persist($ingredient);            
        }
           
        $manager->flush();
    }
}
