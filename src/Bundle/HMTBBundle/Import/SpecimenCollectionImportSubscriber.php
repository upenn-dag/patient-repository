<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\HMTBBundle\Import;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Accard\Bundle\ResourceBundle\Import\Events;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Component\Core\Model\Sample;
use Accard\Component\Core\Model\Source;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Sample\Model\FieldValue;

/**
 * Prototyped importer event subscriber.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 * 
 */
class SpecimenCollectionImportSubscriber implements EventSubscriberInterface
{
    private $prototypeProvider;

    public function __construct(PrototypeProviderInterface $prototypeProvider)
    {
        $this->prototypeProvider = $prototypeProvider;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            Events::CONVERT => array('convertRecords', -10),
        );
    }

    /**
     * Converts record array into actual target entity.
     *
     * If this ends up being called, it will attempt to write the record using
     * the convention that all data within the record will be writable via. the
     * PropertyAccess Symfony component. If custom logic is required, you should
     * create an event that fires before this one and stops propagation if it is
     * successful.
     *
     * @param ImportEvent $event
     */
    public function convertRecords(ImportEvent $event)
    {
        $importer = $event->getImporter();
        if(!('sample' === $importer->getSubject() && 'hmtb_specimens_collection' === $importer->getName())){
            return;
        }

        $records = $event->getRecords();
        $repo = $event->getTarget()->getRepository();
        $prototype = $this->prototypeProvider->getPrototypeByName('specimen-collection');

        $fields['sample-type'] = $prototype->getFieldByName('specimen-collection-sample-type');
        $fields['restricted'] = $prototype->getFieldByName('specimen-collection-restricted');
        $fields['subtype'] = $prototype->getFieldByName('specimen-collection-subtype');
        $fields['total-sum-vials-remaining'] = $prototype->getFieldByName('specimen-collection-total-sum-vials-remaining');
        $fields['blasts'] = $prototype->getFieldByName('specimen-collection-blasts');
        $fields['ct-cyle'] = $prototype->getFieldByName('specimen-collection-ct-cycle');
        $fields['ct-study-day'] = $prototype->getFieldByName('specimen-collection-ct-study-day');
        $fields['ct-peak-through'] = $prototype->getFieldByName('specimen-collection-ct-peak-through');
        $fields['ct-time-post-drug'] = $prototype->getFieldByName('specimen-collection-ct-time-post-drug');
        $fields['ct-time-post-drug-unit'] = $prototype->getFieldByName('specimen-collection-ct-time-post-drug-unit');
        $fields['ct-treatment-relation-time'] = $prototype->getFieldByName('specimen-collection-ct-treatment-relation-time');
        $fields['when-modified'] = $prototype->getFieldByName('specimen-collection-when-modified');

        $sources = array();


        foreach ($records as $key => $record) {
            $source = new Source();
            $source->setPatient($record['patient']);
            $source->setSourceDate($record['activity_date']);
            $source->setAmount(1);

            $sample = new Sample();
            $sample->setPrototype($prototype);
            $sample->setAmount(1);

            $source->addSample($sample);

            foreach($fields as $key => $field) {
                if(method_exists($field, 'getName'))
                {             
                    $fieldValue = new FieldValue;
                    $fieldValue->setField($field);
                    $fieldValue->setSample($sample);
                    $fieldValue->setValue($record[str_replace('specimen_collection_', '', str_replace('-', '_', $field->getName()))]);
                    $sources[$record['identifier'] . $field->getName()] = $fieldValue;
                }
            }
            $sources[$record['identifier']] = $source;

            unset($records[$key]);
        }

        $event->setRecords($sources);
    }
}
