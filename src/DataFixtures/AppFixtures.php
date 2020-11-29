<?php

namespace App\DataFixtures;

use App\Entity\Attribution;
use App\Entity\Client;
use App\Entity\Ordinateur;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 0; $i < 7; $i++) {
            $client = new Client();
            $client->setName('Client '.$i);
            $client->setFirstname('Prenom '.$i);
            $manager->persist($client);
            
            $ordi = new Ordinateur();
            $ordi->setName('Ordi '.$i);
            $manager->persist($ordi);

        }
        
        $manager->flush();
    }
}
