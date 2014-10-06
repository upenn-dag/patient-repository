<?php
// src/Accard/Bundle/DiagnosisBundle/DataFixtures/ORM/LoadFamilyCancerCodeGroupData.php

namespace Accard\Bundle\DiagnosisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Diagnosis\Model\CodeGroup;

/**
 * icd-9 group fixture
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadICD9CodeGroupData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $icd9CodeGroup = new CodeGroup();
        $icd9CodeGroup->setName('icd9');
        $icd9CodeGroup->setPresentation('ICD-9');

        $manager->persist($icd9CodeGroup);
        $manager->flush();

        $this->addReference('icd9CodeGroup', $icd9CodeGroup);
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1; // the order in which fixtures will be loaded
    }
}