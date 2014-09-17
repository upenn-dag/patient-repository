<?php
// src/Accard/Bundle/OptionBundle/Doctrine/DataFixtures/ORM/LoadOptionData.php

namespace Accard\Bundle\OptionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Option\Model\Option;

/**
 * option fixture
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadOptionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $genderOption = new Option();
        $genderOption->setName('gender');
        $genderOption->setPresentation('Gender');

        $manager->persist($genderOption);

        $raceOption = new Option();
        $raceOption->setName('race');
        $raceOption->setPresentation('Race');

        $manager->persist($raceOption);
        $manager->flush();

        $this->addReference('raceOption', $raceOption);
        $this->addReference('genderOption', $genderOption);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}