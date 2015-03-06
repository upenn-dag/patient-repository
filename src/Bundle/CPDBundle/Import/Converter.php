<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CPDBundle\Import;

use Accard\Bundle\ResourceBundle\Import\ConverterInterface;
use Accard\Bundle\ResourceBundle\Import\Events;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Component\Core\Model\Sample;
use Accard\Component\Core\Model\Source;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Sample\Model\FieldValue;

/**
 * CPD Records Converter
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * 
 */
class Converter implements ConverterInterface
{
    private $prototypeProvider;

    public function __construct(PrototypeProviderInterface $prototypeProvider)
    {
        $this->prototypeProvider = $prototypeProvider;
    }

    /**
     * Converts record array into actual target entity.
     *
     * @param ImportEvent $event
     */
    public function convert(ImportEvent $event)
    {
        $importer = $event->getImporter();

        if(!('sample' == $importer->getSubject() && 'cpd_genetic_results' == $importer->getName())) {
            return;
        }

        $records = $event->getRecords();
        $repo = $event->getTarget()->getRepository();
        $prototype = $this->prototypeProvider->getPrototypeByName('genetic-results');

        $fields['cpd-id'] = $prototype->getFieldByName('genetic-results-cpd-id');
        $fields['gene-id'] = $prototype->getFieldByName('genetic-results-gene-id');
        $fields['gene'] = $prototype->getFieldByName('genetic-results-gene');
        $fields['variant-detected'] = $prototype->getFieldByName('genetic-results-variant-detected');
        $fields['variant-categorization'] = $prototype->getFieldByName('genetic-results-variant-categorization');
        $fields['cdna-change'] = $prototype->getFieldByName('genetic-results-cdna-change');
        $fields['mutation-type-cdna'] = $prototype->getFieldByName('genetic-results-mutation-type-cdna');
        $fields['mutation-type-protein'] = $prototype->getFieldByName('genetic-results-mutation-type-protein');
        $fields['variant-alias'] = $prototype->getFieldByName('genetic-results-variant-alias');
        $fields['genetic-test-version-id'] = $prototype->getFieldByName('genetic-results-genetic-test-version-id');
        $fields['transcript-id'] = $prototype->getFieldByName('genetic-results-transcript-id');
        $fields['position'] = $prototype->getFieldByName('genetic-results-position');
        $fields['genotype'] = $prototype->getFieldByName('genetic-results-genotype');
        $fields['fdp'] = $prototype->getFieldByName('genetic-results-fdp');
        $fields['frd'] = $prototype->getFieldByName('genetic-results-frd');
        $fields['fad'] = $prototype->getFieldByName('genetic-results-fad');
        $fields['faf'] = $prototype->getFieldByName('genetic-results-faf');

        $sources = array();
        foreach ($records as $key => $record) {
            $source = new Source();
            $source->setPatient($record['patient']);
            $source->setSourceDate($record['activity_date']);
            $source->setAmount(1);

            $sample = new Sample();
            $sample->setPrototype($prototype);
            $sample->setPatient($record['patient']);

            $source->addSample($sample);

            if (array_key_exists('diagnosis', $record)) {
                $sample->setDiagnosis($record['diagnosis']);
            }

            foreach($fields as $key => $field) {
                $fieldValue = new FieldValue;
                $fieldValue->setField($field);
                $fieldValue->setValue($record[str_replace('genetic_results_', '', str_replace('-', '_', $field->getName()))]);

                $sample->addField($fieldValue);
            }

            $sources[$record['pk_id']] = $source;
            unset($records[$key]);
        }

        $event->setRecords($sources);
   }
}