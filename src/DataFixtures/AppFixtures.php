<?php

namespace App\DataFixtures;

use App\Entity\Compagny;
use App\Entity\Customer;
use App\Entity\Status;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $faker = Factory::create("fr_FR");
        $statusType = ["en attente", "en cours", "terminée"];
        foreach ($statusType as $statusValue) {
            $status = (new Status())
            ->setTitle($statusValue);
            
            $manager->persist($status);
        }

        for ($i=0; $i < 30; $i++) { 
            $customer = (new Customer())
            ->setFirstname($faker->firstName())
            ->setLastname($faker->lastName)
            ->setPhone($faker->phoneNumber)
            ->setEmail($faker->email);

            $manager->persist($customer);
        }

        for ($i=0; $i < 10; $i++) { 
            $customer = (new Compagny())
            ->setName($faker->company)
            ->setSiret($faker->randomNumber())
            ->setAddress($faker->address)
            ->setZipCode($faker->postcode)
            ->setCity($faker->city);

            $manager->persist($customer);
        }

        $manager->flush();
    }
}