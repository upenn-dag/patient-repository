<?php
// src/Accard/Bundle/DiagnosisBundle/DataFixtures/ORM/LoadFamilyCancerCodeGroupData.php

namespace Accard\Bundle\DiagnosisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Diagnosis\Model\CodeGroup;

/**
 * diagnosis code group fixture
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadFamilyCancerCodeGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $codeGroup = new CodeGroup();
        $codeGroup->setName('family_cancer');
        $codeGroup->setPresentation('Family Cancer');

        $manager->persist($codeGroup);
        $manager->flush();

        $this->addReference('family_cancer', $codeGroup);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}