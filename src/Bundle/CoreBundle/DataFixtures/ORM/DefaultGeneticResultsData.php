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
 * Default Genetic Results Prototypes and fields (for CPD specifically)
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DefaultGeneticResultsData extends AccardFixture
{
    /**
     * {@inheritdoc}
     */
    public function doLoad()
    {
        $fm = $this->fixtureManager;

        if (!$fm->hasPrototype('activity', 'genetic_results')) {
            $geneticResults = $fm->createPrototype('activity', 'genetic-results', 'Genetic Results');
            
            $geneticResults
                    ->addField('genetic-results-cpd-id', 'CPD ID', 'text')
                    ->addField('genetic-results-gene', 'Gene', 'text')
                    ->addField('genetic-results-gene-id', 'Gene ID', 'text')
                    ->addField('genetic-results-variant-detected', 'Variant Detected', 'text')
                    ->addField('genetic-results-variant-categorization', 'Variant Categorization', 'text')
                    ->addField('genetic-results-cdna-change', 'CDNA Change', 'text')
                    ->addField('genetic-results-mutation-type-cdna', 'Mutation Type CDNA', 'text')
                    ->addField('genetic-results-mutation-type-protein', 'Mutation Type Protein', 'text')
                    ->addField('genetic-results-variant-alias', 'Variant Alias', 'text')
                    ->addField('genetic-results-genetic-test-version-id', 'Genetic Test Version', 'text')
                    ->addField('genetic-results-transcript-id', 'Transcript ID' ,'text')
                    ->addField('genetic-results-position', 'Position' ,'text')
                    ->addField('genetic-results-fdp','FDP' ,'text')
                    ->addField('genetic-results-frd', 'FRD' ,'text')
                    ->addField('genetic-results-fad',  'FAD' ,'text')
                    ->addField('genetic-results-faf', 'FAF', 'text')
                    ->addField('genetic-results-genotype', 'Genotype', 'text')
                    ->end()
            ->persist();
        }

        $fm->objectManager->flush();
    }
}
