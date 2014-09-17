<?php
// src/Accard/Bundle/OptionBundle/Doctrine/DataFixtures/ORM/LoadOptionValueData.php

namespace Accard\Bundle\OptionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Option\Model\OptionValue;

/**
 * gender option value fixture.
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadGenderOptionValueData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $genderMaleOptionValue = new OptionValue();
        $genderMaleOptionValue->setValue('Male');
        $genderMaleOptionValue->setOption($this->getReference('genderOption'));

        $manager->persist($genderMaleOptionValue);

        $genderFemaleOptionValue = new OptionValue();
        $genderFemaleOptionValue->setValue('Female');
        $genderFemaleOptionValue->setOption($this->getReference('genderOption'));

        $manager->persist($genderFemaleOptionValue);

        $genderUnknownOptionValue = new OptionValue();
        $genderUnknownOptionValue->setValue('Unknown');
        $genderUnknownOptionValue->setOption($this->getReference('genderOption'));

        $manager->persist($genderUnknownOptionValue);

        $manager->flush();
        
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 2; // the order in which fixtures will be loaded
    }
}