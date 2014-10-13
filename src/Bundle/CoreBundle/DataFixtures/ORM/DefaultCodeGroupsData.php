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
use Accard\Component\Diagnosis\Model\CodeGroup;

/**
 * Default Accard code groups (required to start application).
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DefaultCodeGroupsData extends AbstractFixture implements OrderedFixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $main = new CodeGroup();
        $main->setName('main');
        $main->setPresentation('Main');

        $familyCancers = new CodeGroup();
        $familyCancers->setName('family-cancers');
        $familyCancers->setPresentation('Family Cancers');

        $preExistingConditions = new CodeGroup();
        $preExistingConditions->setName('pre-existing-conditions');
        $preExistingConditions->setPresentation('Pre-Existing Conditions');

        $icd9 = new CodeGroup();
        $icd9->setName('icd9');
        $icd9->setPresentation('ICD-9');
        $this->addReference('icd9', $icd9);

        $manager->persist($main);
        $manager->persist($preExistingConditions);
        $manager->persist($familyCancers);
        $manager->persist($icd9);
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