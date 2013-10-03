<?php

namespace Acme\DemoBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class Fixtures extends AbstractFixture implements OrderedFixtureInterface {
    
    public function load(ObjectManager $manager) {
        $loader = new \Nelmio\Alice\Loader\Yaml();
        $objects = $loader->load(__DIR__.'/fixtures.yml');
        
        $persister = new \Nelmio\Alice\ORM\Doctrine($manager);
        $persister->persist($objects);
        
//        $prod1 = new Product();
//        $prod1->setName("portocale")->setPrice(2)->setDescription("portocale de vanzare");
//        $prod1->setCategory($manager->merge($this->getReference("categ-1")));
//        $manager->persist($prod1);
//        
//        $prod2 = new Product();
//        $prod2->setName("struguri")->setPrice(2,5)->setDescription("struguri de la Moldova");
//        $prod2->setCategory($manager->merge($this->getReference("categ-1")));
//        $manager->persist($prod2);
//        
//        $prod3 = new Product();
//        $prod3->setName("rosii")->setPrice(3)->setDescription("rosii de Banat");
//        $prod3->setCategory($manager->merge($this->getReference("categ-2")));
//        $manager->persist($prod3);
//        
//        $prod4 = new Product();
//        $prod4->setName("prajitor de paine")->setPrice(79,9)->setDescription("prajitor de paine");
//        $prod4->setCategory($manager->merge($this->getReference("categ-3")));
//        $manager->persist($prod4);
//        
//        $prod5 = new Product();
//        $prod5->setName("prajitor de paine")->setPrice(79,9)->setDescription("prajitor de paine");
//        $prod5->setCategory($manager->merge($this->getReference("categ-4")));
//        $manager->persist($prod5);
        
        $manager->flush($objects);
    }
    
    public function getOrder()
    {
        return 1;
    }
    
}
