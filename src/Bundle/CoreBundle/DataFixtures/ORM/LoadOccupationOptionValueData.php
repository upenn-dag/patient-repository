<?php
// src/Accard/Bundle/OptionBundle/Doctrine/DataFixtures/ORM/LoadOptionValueData.php

namespace Accard\Bundle\OptionBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Option\Model\OptionValue;

/**
 * occupation industy option value fixture.
 * 
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadOccupationIndustryOptionValueData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $industryAccountingOptionValue = new OptionValue();
        $industryAccountingOptionValue->setValue('Accounting');
        $industryAccountingOptionValue->setOption($this->getReference('industryOption'));

        $manager->persist($industryAccountingOptionValue);

        $industryInfoSystemsOptionValue = new OptionValue();
        $industryInfoSystemsOptionValue->setValue('Information Systems');
        $industryInfoSystemsOptionValue->setOption($this->getReference('industryOption'));

        $manager->persist($industryInfoSystemsOptionValue);

        $industryNursingOptionValue = new OptionValue();
        $industryNursingOptionValue->setValue('Nursing');
        $industryNursingOptionValue->setOption($this->getReference('industryOption'));

        $manager->persist($industryNursingOptionValue);

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