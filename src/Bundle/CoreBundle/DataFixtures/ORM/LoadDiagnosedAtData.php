<?php
// src/Accard/Bundle/CoreBundle/DataFixtures/ORM/LoadICD9OptionData.php

namespace Accard\Component\Behavior\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Diagnosis\Model\Field;

/**
 * diagnosed at field fixture
 *
 * This is only present when the user doesn't select "Diagnosed at UPHS"
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadDiagnosedAtFieldData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $diagnosedAtField = new Field();
        $diagnosedAtField->setName('diagnosed_at_');
        $diagnosedAtField->setPresentation('Diagnosed at');
        $diagnosedAtField->setType('text');

        $manager->persist($diagnosedAtField);
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