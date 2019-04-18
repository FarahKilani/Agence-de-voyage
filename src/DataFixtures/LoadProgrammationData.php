<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use DateTime;
use App\Entity\ProgrammationCircuit;




class LoadProgrammationData extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $circuit=$this->getReference('idf-circuit');        
        $programmation=new ProgrammationCircuit();        
        
        
        //$programmation->setCircuit($circuit);
        $dateDepart=new DateTime("now");
        $programmation->setDateDepart($dateDepart);
        $programmation->setNombrePersonnes(10);
        $programmation->setPrix(100);
        
        $circuit->addProgrammation($programmation);
        
        $manager->persist($programmation);
        $manager->persist($circuit);
        
        $manager->flush();
        
        $circuit=$this->getReference('italie-circuit');
        $programmation=new ProgrammationCircuit();
        
        
        //$programmation->setCircuit($circuit);
        $dateDepart=new DateTime("now");
        $programmation->setDateDepart($dateDepart);
        $programmation->setNombrePersonnes(20);
        $programmation->setPrix(150);
        
        $circuit->addProgrammation($programmation);
        
        $manager->persist($programmation);
        $manager->persist($circuit);
        
        $manager->flush();
        
        
    }
    public function getDependencies()
    {
        return array(
            LoadCircuitData::class,
        );
    }
    
}

