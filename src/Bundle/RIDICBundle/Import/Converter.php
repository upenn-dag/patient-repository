<?php
namespace Accard\Bundle\RIDICBundle\Import;

/**
 * RIDIC \ Import \ Converter
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

use DAG\Bundle\ResourceBundle\Import\ConverterInterface;
use DAG\Bundle\ResourceBundle\Import\Events;
use DAG\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Component\Core\Model\Activity;
use Accard\Component\Core\Model\Source;
use DAG\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Activity\Model\FieldValue;

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
        $prototype = $this->prototypeProvider->getPrototypeByName('ridic-dose');

        $fields = array();

        $fields['0'] = $prototype->getFieldByName('0');
        $fields['first-treatment'] = $prototype->getFieldByName('first-treatment');
        $fields['last-treatment'] = $prototype->getFieldByName('last-treatment');
        $fields['course-ser'] = $prototype->getFieldByName('course-ser');
        $fields['course-serv'] = $prototype->getFieldByName('course-serv');
        $fields['course-id'] = $prototype->getFieldByName('course-id');
        $fields['hup-mrn'] = $prototype->getFieldByName('hup-mrn');
        $fields['attending-npi'] = $prototype->getFieldByName('attending-npi');
        $fields['treatment-intent'] = $prototype->getFieldByName('treatment-intent');
        $fields['department-ser'] = $prototype->getFieldByName('department-ser');
        $fields['pcam-yn'] = $prototype->getFieldByName('pcam-yn');
        $fields['pah-yn'] = $prototype->getFieldByName('pah-yn');
        $fields['chh-yn'] = $prototype->getFieldByName('chh-yn');
        $fields['dh-yn'] = $prototype->getFieldByName('dh-yn');
        $fields['vf-yn'] = $prototype->getFieldByName('vf-yn');
        $fields['first-treatment-dt'] = $prototype->getFieldByName('first-treatment-dt');
        $fields['last-treatment-dt'] = $prototype->getFieldByName('last-treatment-dt');
        $fields['days-elapsed'] = $prototype->getFieldByName('days-elapsed');
        $fields['days-treated'] = $prototype->getFieldByName('days-treated');
        $fields['first-treatment-modality'] = $prototype->getFieldByName('first-treatment-modality');
        $fields['linac-yn'] = $prototype->getFieldByName('linac-yn');
        $fields['proton-yn'] = $prototype->getFieldByName('proton-yn');
        $fields['conformal-yn'] = $prototype->getFieldByName('conformal-yn');
        $fields['imrt-yn'] = $prototype->getFieldByName('imrt-yn');
        $fields['arc-yn'] = $prototype->getFieldByName('arc-yn');
        $fields['rapid-arc-yn'] = $prototype->getFieldByName('rapid-arc-yn');
        $fields['stereotactic-yn'] = $prototype->getFieldByName('stereotactic-yn');
        $fields['tbi-yn'] = $prototype->getFieldByName('tbi-yn');
        $fields['single-scattering-yn'] = $prototype->getFieldByName('single-scattering-yn');
        $fields['double-scattering-yn'] = $prototype->getFieldByName('double-scattering-yn');
        $fields['uniform-scanning-yn'] = $prototype->getFieldByName('uniform-scanning-yn');
        $fields['pbs-yn'] = $prototype->getFieldByName('pbs-yn');
        $fields['electron-static-yn'] = $prototype->getFieldByName('electron-static-yn');
        $fields['hdtse-yn'] = $prototype->getFieldByName('hdtse-yn');
        $fields['cyberknife-yn'] = $prototype->getFieldByName('cyberknife-yn');
        $fields['ref-point-serv'] = $prototype->getFieldByName('ref-point-serv');
        $fields['ref-point-id'] = $prototype->getFieldByName('ref-point-id');
        $fields['rx-total-dose'] = $prototype->getFieldByName('rx-total-dose');
        $fields['rx-daily-dose'] = $prototype->getFieldByName('rx-daily-dose');
        $fields['rx-session-dose'] = $prototype->getFieldByName('rx-session-dose');
        $fields['rx-fraction'] = $prototype->getFieldByName('rx-fraction');
        $fields['treated-total-dose'] = $prototype->getFieldByName('treated-total-dose');
        $fields['treated-fractions'] = $prototype->getFieldByName('treated-fractions');
        $fields['icd9-code'] = $prototype->getFieldByName('icd9-code');
        $fields['dx-desc'] = $prototype->getFieldByName('dx-desc');
        $fields['ref-point-ser'] = $prototype->getFieldByName('ref-point-ser');
        $fields['rx-fractions'] = $prototype->getFieldByName('rx-fractions');
        $fields['patient-ser'] = $prototype->getFieldByName('patient-ser');

        $activities = array();
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
                    $fieldValue->setValue($record[str_replace('-', '_', $field->getName())]);

                    $activities[$record['identifier'] . $field->getName()] = $fieldValue;
                }
            }

            $activities[$record['identifier']] = $activity;
            unset($records[$key]);
        }

        $event->setRecords($activities);
    }
}