<?php
// src/Accard/Bundle/DiagnosisBundle/DataFixtures/ORM/LoadMainDiagnosisCodeGroupData.php

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

class LoadMainCodeGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $codeGroup = new CodeGroup();
        $codeGroup->setName('main');
        $codeGroup->setPresentation('Main');

        $manager->persist($codeGroup);

        $manager->flush();

    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}