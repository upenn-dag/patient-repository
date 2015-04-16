<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\RIDICBundle\Import;

use PDO;
use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\ActivityBundle\Import\ActivityImporter;
use Accard\Bundle\ResourceBundle\Import\ImporterInterface;
use Accard\Bundle\CoreBundle\Provider\ImportPatientProvider;
use Accard\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use Accard\Bundle\ResourceBundle\Import\CriteriaInterface;

/**
 *  RIDIC \ Import \ RIDIC Importer
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class RIDICImporter extends ActivityImporter
{
    /**
     * Patient provider.
     *
     * @var ImportPatientProvider
     */
    private $provider;

    /**
     * RIDIC source.
     *
     * @var SourceAdapterInterface
     */
    private $ridicSource;

    /**
     * Local source.
     *
     * @var SourceAdapterInterface
     */
    private $localSource;

    /**
     * Constructor.
     *
     * @var ImportPatientProvider
     * @var SourceAdapterInterface
     */
    public function __construct(ImportPatientProvider $provider,
    							SourceAdapterInterface $ridicSource,
                                SourceAdapterInterface $localSource)
    {
        $this->provider = $provider;
        $this->ridicSource = $ridicSource;
        $this->localSource = $localSource;
    }

    /**
     * {@inheritdoc}
     */
    public function run(OptionsResolverInterface $resolver)
    {

        $records = array();
        $localRecords = $this->localSource->execute();
        $results = $this->ridicSource->execute();

        foreach($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);

            $mrn = $result['hup_mrn'];

            try {
                $result['previous_record'] = $this->provider->getPatientByMRN($mrn);
            } catch (PatientNotFoundException $e) {
                unset($result, $results[$key]);
                continue;
            }

            $result['identifier'] = $result['course_ser'];
            $result['patient']    = $result['hup_mrn'];
            $result['activity_date']    = $result['first_treatment_dt'];

            $result['import_description'] = sprintf('%s ridic dose on the %s.', $result['course_ser'], $result['hup_mrn']);

            $record = $resolver->resolve($result);

            if($record['patient'] && !in_array($record['course_ser'], $localRecords)) {
                $records[] = $record;
            }

            unset($results[$key]);
        }

        return $records;
    }

    /**
     * {@inheritdoc}
     */
    public function configureResolver(OptionsResolverInterface $resolver)
    {
        parent::configureResolver($resolver);

        $resolver->setDefaults(array(
            //from TREATED_COURSES table
            '0' => 'null',
            'first_treatment' => 'null',
            'last_treatment' => 'null',
            'course_ser' => 'null',
            'course_serv' => 'null',
            'course_id' => 'null',
            'hup_mrn' => 'null',
            'attending_npi' => 'null',
            'treatment_intent' => 'null',
            'department_ser' => 'null',
            'pcam_yn' => 'null',
            'pah_yn' => 'null',
            'chh_yn' => 'null',
            'dh_yn' => 'null',
            'vf_yn' => 'null',
            'first_treatment_dt' => 'null',
            'last_treatment_dt' => 'null',
            'days_elapsed' => 'null',
            'days_treated' => 'null',
            'first_treatment_modality' => 'null',
            'linac_yn' => 'null',
            'proton_yn' => 'null',
            'conformal_yn' => 'null',
            'imrt_yn' => 'null',
            'arc_yn' => 'null',
            'rapid_arc_yn' => 'null',
            'stereotactic_yn' => 'null',
            'tbi_yn' => 'null',
            'single_scattering_yn' => 'null',
            'double_scattering_yn' => 'null',
            'uniform_scanning_yn' => 'null',
            'pbs_yn' => 'null',
            'electron_static_yn' => 'null',
            'hdtse_yn' => 'null',
            'cyberknife_yn' => 'null',
            //from v_COURSE_DOSE
            'ref_point_serv' => 'null',
            'ref_point_id' => 'null',
            'rx_total_dose' => 'null',
            'rx_daily_dose' => 'null',
            'rx_session_dose' => 'null',
            'rx_fraction' => 'null',
            'treated_total_dose' => 'null',
            'treated_fractions' => 'null',
            //from v_COURSE_PRIM_CaDx
            'icd9_code' => 'null',
            'dx_desc' => 'null',
            'ref_point_ser' => 'null',
            'rx_fractions' => 'null',
            'patient_ser' => 'null'
        ));

        $resolver->setDefined(array(
            //from TREATED_COURSES table
            '0',
            'first_treatment',
            'last_treatment',
            'course_ser',
            'course_serv',
            'course_id',
            'hup_mrn',
            'attending_npi',
            'treatment_intent',
            'department_ser',
            'pcam_yn',
            'pah_yn',
            'chh_yn',
            'dh_yn',
            'vf_yn',
            'first_treatment_dt',
            'last_treatment_dt',
            'days_elapsed',
            'days_treated',
            'first_treatment_modality',
            'linac_yn',
            'proton_yn',
            'conformal_yn',
            'imrt_yn',
            'arc_yn',
            'rapid_arc_yn',
            'stereotactic_yn',
            'tbi_yn',
            'single_scattering_yn',
            'double_scattering_yn',
            'uniform_scanning_yn',
            'pbs_yn',
            'electron_static_yn',
            'hdtse_yn',
            'cyberknife_yn',
            //from v_COURSE_DOSE
            'ref_point_serv',
            'ref_point_id',
            'rx_total_dose',
            'rx_daily_dose',
            'rx_session_dose',
            'rx_fraction',
            'treated_total_dose',
            'treated_fractions',
            //from v_COURSE_PRIM_CaDx
            'icd9_code',
            'dx_desc',
            'ref_point_ser',
            'rx_fractions',
            'patient_ser',
        ));

        $resolver->setOptional(array(
            //from v_COURSE_PRIM_CaDx
            'dx_comments',
            'stage',
            'stage_basis',
            't',
            'n',
            'm',
            'g',
            'psa',
        ));

        $resolver->setAllowedTypes(array(
            'course_serv'           => 'string',
            'ref_point_serv'        => 'string',
            'ref_point_id'          => 'string',
            'rx_total_dose'         => array('string', 'null'),
            'rx_daily_dose'         => array('string', 'null'),
            'rx_session_dose'       => array('string', 'null'),
            'rx_fraction'           => array('string', 'null'),
            'treated_total_dose'    => array('string', 'null'),
            'treated_fractions'     => array('string', 'null'),
            'icd9_code'             => 'string',
            'dx_desc'               => 'string',
            'dx_comments'           => array('string', 'null'),
            'stage'                 => array('string', 'null'),
            'stage_basis'           => array('string', 'null'),
            't'                     => array('string', 'null'),
            'n'                     => array('string', 'null'),
            'm'                     => array('string', 'null'),
            'g'                     => array('string', 'null'),
            'psa'                   => array('string', 'null'),
        ));

        $resolver->setAllowedValues(array(

        ));
    }

    public function getCodes()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteria(array $history = null)
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCriteria()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'ridic_doses';
    }
}