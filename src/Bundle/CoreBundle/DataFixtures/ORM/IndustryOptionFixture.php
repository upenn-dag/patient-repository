<?php

namespace Accard\Bundle\CoreBundle\DataFixtures\ORM;

use Accard\Bundle\CoreBundle\DataFixtures\AccardFixture;
use Doctrine\Common\Persistence\ObjectManager;

class OccupationOptionFixture extends AccardFixture
{
    /**
     * {@inheritDoc}
     */
    public function doLoad()
    {
    	$fm = $this->fixtureManager;

    	$industry = $fm->createOption('industry', 'Industry')
            ->addOptionValue('Accounting')
            ->addOptionValue('Information Systems')
            ->addOptionValue('Nursing')
        ->persist();

        $fm->objectManager->flush();
    }
}