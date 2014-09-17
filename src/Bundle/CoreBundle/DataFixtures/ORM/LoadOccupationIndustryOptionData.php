<?php
// src/Accard/Bundle/DiagnosisBundle/DataFixtures/ORM/LoadOccupationIndustryOptionData.php

namespace Accard\Component\Behavior\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Option\Model\Option;

/**
 * industry behavior industry option fixture
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadOccupationIndustryOptionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $industryOption = new Option();
        $industryOption->setName('industry');
        $industryOption->setPresentation('Industy');

        $manager->persist($industryOption);
        $manager->flush();

        $this->addReference('industryOption', $industryOption);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}