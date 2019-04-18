<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Circuit;
class LoadCircuitData extends Fixture
{
	public function load(ObjectManager $manager)
	{		
		$circuit = new Circuit();
		$circuit->setDescription('Andalousie');
		$circuit->setPaysDepart('Espagne');
		$circuit->setVilleDepart('Grenade');
		$circuit->setVilleArrivee('Séville');
		$circuit->setDureeCircuit(4);
		$circuit->setUrl('https://www.evasionsprestige.com/images/etd_travels/1287_circuit-andalousie_zoom.jpg');
		$manager->persist($circuit);
		
		$this->addReference('andalousie-circuit', $circuit);
		
		$circuit = new Circuit();
		$circuit->setDescription('Vietnam');
		$circuit->setPaysDepart('VietNam');
		$circuit->setVilleDepart('Hanoi');
		$circuit->setVilleArrivee('Hô Chi Minh');
		$circuit->setDureeCircuit(4);
		$circuit->setUrl('https://exclusivesmedia.webjet.com.au/uploads/2017/12/best-vietnam-nhatrang-5-min.jpg');
		$manager->persist($circuit);
		
		$this->addReference('vietnam-circuit', $circuit);
		
		$circuit = new Circuit();
		$circuit->setDescription('Ile de France');
		$circuit->setPaysDepart('France');
		$circuit->setVilleDepart('Paris');
		$circuit->setVilleArrivee('Paris');
		$circuit->setDureeCircuit(2);
		$circuit->setUrl('http://cdn-europe1.new2.ladmedia.fr/var/europe1/storage/images/europe1/technologies/tout-le-monde-peut-s-offrir-paris-794760/15887078-1-fre-FR/Tout-le-monde-peut-s-offrir-.paris.jpg');
		$manager->persist($circuit);

		$this->addReference('idf-circuit', $circuit);
		
		$circuit = new Circuit();
		$circuit->setDescription('Italie');
		$circuit->setPaysDepart('Italie');
		$circuit->setVilleDepart('Milan');
		$circuit->setVilleArrivee('Rome');
		$circuit->setDureeCircuit(4);
		$circuit->setUrl('http://evasion-online.com/imagearticle/2015/06/Italie-660x330.jpg');
		$manager->persist($circuit);
		
		$this->addReference('italie-circuit', $circuit);
		
		$circuit = new Circuit();
		$circuit->setDescription('Pérou');
		$circuit->setPaysDepart('Pérou');
		$circuit->setVilleDepart('Lima');
		$circuit->setVilleArrivee('Lima');
		$circuit->setDureeCircuit(2);
		$circuit->setUrl('http://img.ev.mu/images/regions/187/1605x642/187.jpg');		
		$manager->persist($circuit);		
		$this->addReference('perou-circuit', $circuit);
		
		$manager->flush();
	}
	
}
// (1, 'Andalousie', 'Espagne', 'Grenade', 'Séville', 4),
// (2, 'VietNam', 'VietNam', 'Hanoi', 'Hô Chi Minh', 4),
// (3, 'Ile de France', 'France', 'Paris', 'Paris', 2),
// (4, 'Italie', 'Italie', 'Milan', 'Rome', 4);