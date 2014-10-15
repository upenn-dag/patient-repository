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

use Accard\Bundle\CoreBundle\DataFixtures\AccardFixture;

/**
 * Default Accard code groups (required to start application).
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DefaultCodeGroupsData extends AccardFixture
{
    /**
     * {@inheritdoc}
     */
    public function doLoad()
    {
        $fm = $this->fixtureManager;

        if (!$fm->hasEntity('diagnosis_code_group', array('name' => 'main'))) {
            $fm->createEntity('diagnosis_code_group')
                ->setName('main')
                ->setPresentation('Main')
            ->persist();
        }

        if (!$fm->hasEntity('diagnosis_code_group', array('name' => 'family-cancers'))) {
            $fm->createEntity('diagnosis_code_group')
                ->setName('family-cancers')
                ->setPresentation('Family Cancers')
            ->persist();
        }

        if (!$fm->hasEntity('diagnosis_code_group', array('name' => 'pre-existing-conditions'))) {
            $fm->createEntity('diagnosis_code_group')
                ->setName('pre-existing-conditions')
                ->setPresentation('Pre-Existing Conditions')
            ->persist();
        }

        if (!$fm->hasEntity('diagnosis_code_group', array('name' => 'icd9'))) {
            $fm->createEntity('diagnosis_code_group')
                ->setName('icd9')
                ->setPresentation('ICD-9')
            ->persist();
        }

        $fm->objectManager->flush();
    }
}
