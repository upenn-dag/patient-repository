<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\DataFixtures\ORM;

use Accard\Bundle\CoreBundle\DataFixtures\AccardFixture;

/**
 * Default options (required on install).
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DefaultOptionsData extends AccardFixture
{
    /**
     * {@inheritdoc}
     */
    public function doLoad()
    {
        $fm = $this->fixtureManager;

        if (!$fm->hasOption('industry')) {
            $fm->createOption('industry', 'Industry')
                ->addOptionValue('Accounting')
                ->addOptionValue('Information Systems')
                ->addOptionValue('Nursing')
            ->persist();
        }

        if (!$fm->hasOption('education-level')) {
            $fm->createOption('education-level', 'Education level')
                ->addOptionValue('High school')
                ->addOptionValue('Undergraduate University')
                ->addOptionValue('Graduate University')
            ->persist();
        }

        if (!$fm->hasOption('gender')) {
            $fm->createoption('gender', 'Gender')
                ->addOptionValue('Male')
                ->addOptionValue('Female')
                ->addOptionValue('Unknown')
            ->persist();
        }

        if (!$fm->hasOption('race')) {
            $fm->createOption('race', 'Race')
                ->addOptionValue('Caucasian')
                ->addOptionValue('Asian')
                ->addOptionValue('African-American')
                ->addOptionValue('Latin')
            ->persist();
        }

        $fm->objectManager->flush();
    }
}
