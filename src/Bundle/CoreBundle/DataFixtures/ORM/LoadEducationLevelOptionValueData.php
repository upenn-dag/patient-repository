<?php
// src/Accard/Bundle/CoreBundle/Doctrine/DataFixtures/ORM/LoadOptionValueData.php

namespace Accard\Bundle\OptionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Option\Model\OptionValue;

/**
 * education level option value fixture.
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadEducationLevelOptionValueData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $educationHighSchoolOptionValue = new OptionValue();
        $educationHighSchoolOptionValue->setValue('High School');
        $educationHighSchoolOptionValue->setOption($this->getReference('levelOption'));

        $manager->persist($educationHighSchoolOptionValue);

        $educationUndergraduateOptionValue = new OptionValue();
        $educationUndergraduateOptionValue->setValue('Undergraduate University');
        $educationUndergraduateOptionValue->setOption($this->getReference('levelOption'));

        $manager->persist($educationUndergraduateOptionValue);

        $educationGraduateOptionValue = new OptionValue();
        $educationGraduateOptionValue->setValue('Graduate University');
        $educationGraduateOptionValue->setOption($this->getReference('levelOption'));

        $manager->persist($educationGraduateOptionValue);

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