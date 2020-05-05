<?php

namespace App\DataFixtures;

use App\Entity\Hero;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        for ($i = 0; $i < 15; $i++) {
            $hero = new Hero($faker->name);
            $manager->persist($hero);
        }

        $manager->flush();
    }
}
