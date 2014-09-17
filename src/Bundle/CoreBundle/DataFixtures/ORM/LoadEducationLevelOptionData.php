<?php
// src/Accard/Bundle/CoreBundle/DataFixtures/ORM/LoadEducationLevelOptionData.php

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

class LoadEducationLevelOptionData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $levelOption = new Option();
        $levelOption->setName('level');
        $levelOption->setPresentation('Level');

        $manager->persist($levelOption);
        $manager->flush();

        $this->addReference('levelOption', $levelOption);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}