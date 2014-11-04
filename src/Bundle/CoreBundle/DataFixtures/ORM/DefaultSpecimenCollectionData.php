<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ActivityBundle\DataFixtures\ORM;

use Accard\Bundle\CoreBundle\DataFixtures\AccardFixture;

/**
 * Default Specimen results (for HMTB specifically).
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DefaultSpecimenCollectionData extends AccardFixture
{
    /**
     * {@inheritdoc}
     */
    public function doLoad()
    {
        $fm = $this->fixtureManager;

        if (!$fm->hasPrototype('sample', 'specimen_collection')) {
            $specimentCollection = $fm->createPrototype('sample', 'specimen-collection', 'Specimen Collection');
            
            $specimentCollection
                ->addField('specimen-collection-sample-type', 'Sample Type', 'text')
                ->addField('specimen-collection-restricted', 'Restricted', 'text')
                ->addField('specimen-collection-subtype', 'Subtype', 'text')
                ->addField('specimen-collection-total-sum-vials-remaining', 'Total Sum Vials Remaining', 'text')
                ->addField('specimen-collection-blasts', 'Blasts', 'text')
                ->addField('specimen-collection-ct-cycle','CT Cycle', 'text')
                ->addField('specimen-collection-ct-study-day', 'CT Study Day', 'text')
                ->addField('specimen-collection-ct_peak_through', 'CT Peak Through', 'text')
                ->addField('specimen-collection-ct-time-post-drug', 'CT Time Post Drug', 'text')
                ->addField('specimen-collection-ct-time-post-drug-unit', 'CT Time Post Drug Unit', 'text')
                ->addField('specimen-collection-ct-treatment-relation-time', 'CT Time in Relation to Treatment', 'text')
                ->addField('specimen-collection-when-modified', 'When Modified', 'text')
                ->end()
            ->persist();
        }

        $fm->objectManager->flush();
    }
}
