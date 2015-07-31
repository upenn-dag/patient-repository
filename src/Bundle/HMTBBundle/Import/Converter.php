<?php
namespace Accard\Bundle\HMTBBundle\Import;

/**
 * HMTB \ Import \ Converter
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

use DAG\Bundle\ResourceBundle\Import\ConverterInterface;
use DAG\Bundle\ResourceBundle\Import\Events;
use DAG\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Component\Core\Model\Sample;
use Accard\Component\Core\Model\Source;
use DAG\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Sample\Model\FieldValue;

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
        if (!('sample' === $importer->getSubject() && 'hmtb_specimens_collection' === $importer->getName())) {
            return;
        }

        $records = $event->getRecords();
        $repo = $event->getTarget()->getRepository();
        $prototype = $this->prototypeProvider->getPrototypeByName('specimen-collection');

        $fields['sample-type'] = $prototype->getFieldByName('hmtb-sample-type');
        $fields['restricted'] = $prototype->getFieldByName('hmtb-restricted');
        $fields['subtype'] = $prototype->getFieldByName('hmtb-subtype');
        $fields['total-sum-vials-remaining'] = $prototype->getFieldByName('hmtb-total-sum-vials-remaining');
        $fields['blasts'] = $prototype->getFieldByName('hmtb-blasts');
        $fields['ct-cyle'] = $prototype->getFieldByName('hmtb-ct-cycle');
        $fields['ct-study-day'] = $prototype->getFieldByName('hmtb-ct-study-day');
        $fields['ct-peak-through'] = $prototype->getFieldByName('hmtb-ct-peak-through');
        $fields['ct-time-post-drug'] = $prototype->getFieldByName('hmtb-ct-time-post-drug');
        $fields['ct-time-post-drug-unit'] = $prototype->getFieldByName('hmtb-ct-time-post-drug-unit');
        $fields['ct-treatment-relation-time'] = $prototype->getFieldByName('hmtb-ct-treatment-relation-time');
        $fields['when-modified'] = $prototype->getFieldByName('hmtb-when-modified');

        $sources = array();


        foreach ($records as $key => $record) {
            $source = new Source();
            $source->setPatient($record['patient']);
            $source->setSourceDate($record['activity_date']);
            $source->setAmount(1);

            $sample = new Sample();
            $sample->setPrototype($prototype);
            $sample->setAmount(1);
            $sample->setPatient($record['patient']);

            $source->addSample($sample);

            foreach ($fields as $key => $field) {
                if (method_exists($field, 'getName')) {
                    $fieldValue = new FieldValue;
                    $fieldValue->setField($field);
                    $fieldValue->setSample($sample);
                    $fieldValue->setValue($record[str_replace('hmtb_', '', str_replace('-', '_', $field->getName()))]);
                    $sources[$record['identifier'] . $field->getName()] = $fieldValue;
                }
            }
            $sources[$record['identifier']] = $source;

            unset($records[$key]);
        }

        $event->setRecords($sources);
    }
}
