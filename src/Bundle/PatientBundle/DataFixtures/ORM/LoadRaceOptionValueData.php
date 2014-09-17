<?php
// src/Accard/Bundle/OptionBundle/Doctrine/DataFixtures/ORM/LoadOptionValueData.php

namespace Accard\Bundle\OptionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Option\Model\OptionValue;

/**
 * race option value fixture
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadRaceOptionValueData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $raceCaucasianOptionValue = new OptionValue();
        $raceCaucasianOptionValue->setValue('Caucasian');
        $raceCaucasianOptionValue->setOption($this->getReference('raceOption'));

        $manager->persist($raceCaucasianOptionValue);

        $raceAsianOptionValue = new OptionValue();
        $raceAsianOptionValue->setValue('Asian');
        $raceAsianOptionValue->setOption($this->getReference('raceOption'));

        $manager->persist($raceAsianOptionValue);

        $raceAfroAmericanOptionValue = new OptionValue();
        $raceAfroAmericanOptionValue->setValue('African American');
        $raceAfroAmericanOptionValue->setOption($this->getReference('raceOption'));

        $manager->persist($raceAfroAmericanOptionValue);

        $raceLatinOptionValue = new OptionValue();
        $raceLatinOptionValue->setValue('Latin');
        $raceLatinOptionValue->setOption($this->getReference('raceOption'));

        $manager->persist($raceLatinOptionValue);
        $manager->flush();    
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 3; // the order in which fixtures will be loaded
    }
}