<?php
// src/Accard/Bundle/CoreBundle/DataFixtures/ORM/LoadICD9OptionData.php

namespace Accard\Component\Behavior\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Diagnosis\Model\Field;

/**
 * diagnosed at Penn fixture
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadDiagnosedAtUPHSFieldData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $diagnosedAtUPHSField = new Field();
        $diagnosedAtUPHSField->setName('diagnosed_at_UPHS');
        $diagnosedAtUPHSField->setPresentation('Diagnosed at UPHS');
        $diagnosedAtUPHSField->setType('checkbox');

        $manager->persist($diagnosedAtUPHSField);
        $manager->flush();

        $this->addReference('diagnosedAtUPHSField', $diagnosedAtUPHSField);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}