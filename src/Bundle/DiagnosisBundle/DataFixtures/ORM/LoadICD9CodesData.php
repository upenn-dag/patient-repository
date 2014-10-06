<?php
// src/Accard/Bundle/DiagnosisBundle/DataFixtures/ORM/LoadFamilyCancerCodesData.php

namespace Accard\Bundle\DiagnosisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Diagnosis\Model\Code;

/**
 * icd=9 code group fixture
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

class LoadICD9CodesData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $breastCancer = new Code();
        $breastCancer->setCode(2009);
        $breastCancer->setDescription('Breast Cancer');
        $breastCancer->addGroup($this->getReference('icd9CodeGroup'));
        $manager->persist($breastCancer);

        $prostateCancer = new Code();
        $prostateCancer->setCode(2010);
        $prostateCancer->setDescription('Prostate Cancer');
        $prostateCancer->addGroup($this->getReference('icd9CodeGroup'));
        $manager->persist($prostateCancer);

        $thoracicCancer = new Code();
        $thoracicCancer->setCode(2011);
        $thoracicCancer->setDescription('Thoracic Cancer');
        $thoracicCancer->addGroup($this->getReference('icd9CodeGroup'));
        $manager->persist($thoracicCancer);

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