<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Diagnosis\Model\Code;

/**
 * Default Accard code groups (required to start application).
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DefaultCodeData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $icd9Code1 = new Code();
        $icd9Code1->setCode('2000');
        $icd9Code1->setDescription('Generic code 1');
        $icd9Code1->addGroup($this->getReference('icd9'));

        $manager->persist($icd9Code1);
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