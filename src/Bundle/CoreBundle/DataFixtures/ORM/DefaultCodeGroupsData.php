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
use Doctrine\Common\Persistence\ObjectManager;
use Accard\Component\Diagnosis\Model\CodeGroup;

/**
 * Default Accard code groups (required to start application).
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DefaultCodeGroupsData extends AbstractFixture
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

        $manager->persist($main);
        $manager->persist($preExistingConditions);
        $manager->persist($familyCancers);
        $manager->flush();
    }
}