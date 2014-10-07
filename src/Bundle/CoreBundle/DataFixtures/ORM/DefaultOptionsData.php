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
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Default options (required on install).
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DefaultOptionsData extends AccardFixture
{
    /**
     * {@inheritDoc}
     */
    public function doLoad()
    {
        $fm = $this->fixtureManager;

        $fm->createOption('industry', 'Industry')
            ->addOptionValue('Accounting')
            ->addOptionValue('Information Systems')
            ->addOptionValue('Nursing')
        ->persist();

        $fm->createOption('education-level', 'Education level')
            ->addOptionValue('High school')
            ->addOptionValue('Undergraduate University')
            ->addOptionValue('Graduate University')
        ->persist();

        $fm->createoption('gender', 'Gender')
            ->addOptionValue('male', '')
            ->addOptionValue('female', '')
            ->addOptionValue('unknown', '')
        ->persist();

        $fm->createOption('race', 'Race')
            ->addOptionValue('caucasian', '')
            ->addOptionValue('asian', '')
            ->addOptionValue('african-american', '')
            ->addOptionValue('latin', '')
        ->persist();

        $fm->objectManager->flush();
    }
}
