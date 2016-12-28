<?php
/**
 * Loads core utilities
 */

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Utility;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class LoadUtilities implements FixtureInterface

{

    /**
     * Load data fixtures with the passed EntityManager
     *
     * @param ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $utility = new Utility();
        $utility->setName('Газ');
        $manager->persist($utility);
        $manager->flush($utility);

        $utility = new Utility();
        $utility->setName('Электричество');
        $manager->persist($utility);
        $manager->flush($utility);

        $utility = new Utility();
        $utility->setName('Вода');
        $manager->persist($utility);
        $manager->flush($utility);
    }
}