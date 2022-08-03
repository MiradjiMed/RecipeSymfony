<?php

namespace App\DataFixtures;

use Faker\Factory;
use Faker\Generator;
use App\Entity\Recipe;
use App\Entity\Ingredient;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

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
        // Ingredients
        $ingredients = [] ;
        for($i = 1; $i <= 50; $i++) {
            // $product = new Product();
        // $manager->persist($product);
        $ingredient = new Ingredient();
        $ingredient->setName($this->faker->word())  // 'Ingredient ' . $i
                   ->setPrice(mt_rand(0, 100));

        $ingredients[] = $ingredient;           
        $manager->persist($ingredient);            
        }

        // Recipes
        for ($j=0; $j < 25; $j++) { 
            $recipe = new Recipe(); 
            $recipe->setName($this->faker->word())
                   ->setTime(mt_rand(0,1) == 1 ? mt_rand(1, 1440) : null ) 
                   ->setNbPeople(mt_rand(0,1) == 1 ? mt_rand(1, 50) : null)
        }
           
        $manager->flush();
    }
}
