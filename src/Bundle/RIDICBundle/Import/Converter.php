<?php
namespace Accard\Bundle\RIDICBundle\Import;

/**
 * RIDIC \ Import \ Converter
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

use Accard\Bundle\ResourceBundle\Import\ConverterInterface;
use Accard\Bundle\ResourceBundle\Import\Events;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Component\Core\Model\Activity;
use Accard\Component\Core\Model\Source;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Sample\Model\FieldValue;

class Converter implements ConverterInterface
{
    /**
     * Prototype provider
     */
    private $prototypeProvider;

    /**
     * Constructor
     * 
     * @param PrototypeProviderInterace
     */
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
        $records = $event->getRecords();
        $prototype = $prototypeProvider->getPrototypeByName('ridic-dose');

        $fields = array();

        $fields['first-treatment'] = $prototype->getFieldByName('ridic-dose-first-treatment');
        $fields['last-treatment'] = $prototype->getFieldByName('ridic-dose-last-treatment');
        $fields['course-serv'] = $prototype->getFieldByName('ridic-dose-course-serv');
        $fields['hup-mrn'] = $prototype->getFieldByName('ridic-dose-hup-mrn');
        $fields['ref-point-serv'] = $prototype->getFieldByName('ridic-dose-ref-point-serv');
        $fields['ref-point-id'] = $prototype->getFieldByName('ridic-dose-ref-point-id');
        $fields['rx-total-dose'] = $prototype->getFieldByName('ridic-dose-rx-total-dose');
        $fields['rx-daily-dose'] = $prototype->getFieldByName('ridic-dose-rx-daily-dose');
        $fields['rx-session-dose'] = $prototype->getFieldByName('ridic-dose-rx-session-dose');
        $fields['rx-fraction'] = $prototype->getFieldByName('ridic-dose-rx-fraction');
        $fields['treated-total-dose'] = $prototype->getFieldByName('ridic-dose-treated-total-dose');
        $fields['treated-fractions'] = $prototype->getFieldByName('ridic-dose-treated-fractions');
        $fields['icd9-code'] = $prototype->getFieldByName('ridic-dose-icd9-code');
        $fields['dx-desc'] = $prototype->getFieldByName('ridic-dose-dx-desc');
        $fields['dx-comments'] = $prototype->getFieldByName('ridic-dose-dx-comments');
        $fields['stage'] = $prototype->getFieldByName('ridic-dose-stage');
        $fields['stage-basis'] = $prototype->getFieldByName('ridic-dose-stage-basis');
        $fields['t'] = $prototype->getFieldByName('ridic-dose-t');
        $fields['n'] = $prototype->getFieldByName('ridic-dose-n');
        $fields['m'] = $prototype->getFieldByName('ridic-dose-m');
        $fields['g'] = $prototype->getFieldByName('ridic-dose-g');
        $fields['psa'] = $prototype->getFieldByName('ridic-dose-psa');

        foreach( $records as $key => $record ) {
            $activity = new Activity;
            $activity->setPatient($record['patient']);
            $activity->setActivityDate($record['activity_date']);
            $activity->setPrototype($prototype);

            foreach($fields as $key => $field) {
                if(method_exists($field, 'getName')) {             
                    $fieldValue = new FieldValue;
                    $fieldValue->setField($field);
                    $fieldValue->setActivity($activity);
                    $fieldValue->setValue($record[str_replace('ridic_dose_', '', str_replace('-', '_', $field->getName()))]);

                    $activities[$record['identifier'] . $field->getName()] = $fieldValue;
                }
            }

            $activities[$record['identifier']] = $activity;
            unset($records[$key]);
        }

        $event->setRecords($activities);
    }
}