<?php

namespace App\DataFixtures;

use App\Entity\Person;
use App\Entity\Coiffure;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // $product = new Product();
        // $manager->persist($product);
        $faker = Factory::create();
        $persons= [
            'Greg',
            'Loic',
            'Cécile',
            'Remi',
            'Julien',
            'Solène',
            'Alexis',
        ];

        $coiffures = [
            'Afro',
            'Asymétrique',
            'Banane',
            'Bol',
            'Brosse',
            'Boule à zéro',
            'Carré',
            'Couette',
            'Dreadlocks',
        ];

        $coiffuresObject = [];

        foreach($coiffures as $currentCoiffure)
        {
            $coiffure = new Coiffure();
            $coiffure->setName($currentCoiffure);
            $coiffure->setColor($faker->colorName());
            $coiffuresObject[] = $coiffure;
            $manager->persist($coiffure);
        }

        foreach ($persons as $currentPerson) 
        {
            $person = new Person();
            $person->setName($currentPerson);
            $coiffureIndex= array_rand($coiffures);
            $person->setCoiffure($coiffuresObject[$coiffureIndex]);
            $manager->persist($person);
        }

        $manager->flush();
    }
}
