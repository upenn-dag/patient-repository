<?php
// src/Accard/Bundle/DiagnosisBundle/DataFixtures/ORM/LoadPreExistingConditionCodeGroupData.php

namespace Accard\Bundle\DiagnosisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Diagnosis\Model\CodeGroup;

/**
 * pre-existing condition code group fixture
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadPreExistingConditionCodeGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $codeGroup = new CodeGroup();
        $codeGroup->setName('pre_existing_condition');
        $codeGroup->setPresentation('Pre-Existing Condition');

        $manager->persist($codeGroup);
        $manager->flush();

        $this->addReference('pre_existing_condition', $codeGroup);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}