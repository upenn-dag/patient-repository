<?php

namespace Accard\Bundle\CoreBundle\DataFixtures\ORM;

use Accard\Bundle\CoreBundle\DataFixtures\AccardFixture;
use Doctrine\Common\Persistence\ObjectManager;

class EducationOptionFixture extends AccardFixture
{
    /**
     * {@inheritDoc}
     */
    public function doLoad()
    {
    	$fm = $this->fixtureManager;

    	$educationLevel = $fm->createOption('education_level', 'Education level')
            ->addOptionValue('High school')
            ->addOptionValue('Undergraduate University')
            ->addOptionValue('Graduate University')
        ->persist();

        $fm->objectManager->flush();
    }
}