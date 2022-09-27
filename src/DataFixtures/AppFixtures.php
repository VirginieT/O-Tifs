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
            'Carré',
            'Couettes',
            'Longs',
            'Bol',
            'Dreadlocks',
            'Carré',
            'Couettes',
            'Longs',
        ];

        $coiffuresObject = [
            'AfroGreg.png',
            'CarréLoic.png',
            'CouettesCécile.png',
            'LongsRémi.png',
            'DoubleCouetteJulien.png',
            'DreadSolene.png',
            'BouleZéroAlexis.png',
        ];

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

        foreach ($coiffuresObject as $currentCoiffureObject) 
        {
            $coiffureObject = new Coiffure();
            $coiffureObject->setName($currentCoiffureObject);
            $manager->persist($coiffureObject);
        }

        $manager->flush();
    }
}
