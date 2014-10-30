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

use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\ActivityBundle\Import\ActivityImporter;
use Accard\Bundle\ResourceBundle\Import\ImporterInterface;
use Accard\Bundle\CoreBundle\Provider\ImportPatientProvider;
use Doctrine\DBAL\Connection;

/**
 *  HMTB Specimens importer.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class SpecimensCollectionImporter extends ActivityImporter
{
    /**
     * Patient provider.
     *
     * @var ImportPatientProvider
     */
    private $provider;

    /**
     * PDS connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * Diagnosis codes.
     *
     * @var string
     */
    private $codes;

    /**
     * Default start date.
     *
     * @var DateTime
     */
    private $defaultStartDate;

    /**
     * Constructor.
     *
     * @param ImportPatientProvider $provider
     * @param Connection $connection
     * @param array $code
     * @param string|null $defaultStartDate
     */
    public function __construct(ImportPatientProvider $provider,
                                Connection $connection,
                                array $codes)
    {
        $this->provider = $provider;
        $this->connection = $connection;
        $this->codes = $codes;
    }

    public function getCodes()
    {
        return $this->codes;
    }

    /**
     * {@inheritdoc}
     */
    public function run(OptionsResolverInterface $resolver, array $criteria)
    {
        $records = array();
        $stmt = $this->connection->prepare($this->getSQL());
        $stmt->execute();
        $results = $stmt->fetchAll();
        $stmt->closeCursor();

        foreach($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);

            try {
                $result['previous_record'] = $this->provider->getPatientByMRN($result['patient']);
            } catch (PatientNotFoundException $e) {}

            $record['identifier'] = $result['hmtb_id'];
            $result['import_description'] = sprintf('%s specimen on the %s.', $result['hmtb_id'], $result['patient']);

            $record = $resolver->resolve($result);

            if ($record['patient'] && $record['restricted'] == 'No') {
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

       ;

        $resolver->setRequired(array(
            'hmtb_id',
            'sample_type',
            'patient',
            'diagnosis'
        ));

        $resolver->setOptional(array(
                                     '0',
                                     '1',
                                     '2',
                                     'subtype', 
                                     'restricted',
                                     'total_sum_vials_remaining', 
                                     'blasts', 
                                     'ct_cycle',
                                     'ct_study_day', 
                                     'ct_peak_through', 
                                     'ct_time_post_drug', 
                                     'ct_time_post_drug_unit', 
                                     'ct_treatment_relation_time',
                                     'when_modified'));

        $resolver->setAllowedTypes(array(
            'hmtb_id' => array('string'),
            'restricted' => array('string'),
        ));

        $resolver->setAllowedValues(array(
            $sample_type = array('BM-MNC', 'PB-MNC', 'Phereis'),
            $restricted = array('No', 'YES'),
            $diagnosis = array('AML'),
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteria(array $history)
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
        return 'hmtb_specimens_collection';
    }

    /**
     * Get SQL statement.
     *
     * @return string
     */
    private function getSQL()
    {
        $codes = "'".implode("', '", $this->codes)."'";

        return "SELECT
                COLLECTION_ID AS HMTB_ID,
                MEDRECNUM AS PATIENT,
                COLLECTION_ID AS IDENTIFIER,
                TO_CHAR(COLLECTED_DATEDRAWN, 'mm/dd/yyyy') AS ACTIVITY_DATE,
                SAMPLETYPE AS SAMPLE_TYPE,
                RESTRICTEDACCESS_CHECKBOX AS RESTRICTED,
                DIAGNOSIS,
                SUBTYPE,
                TOTAL_SUM_VIALSREMAINING AS TOTAL_SUM_VIALS_REMAINING,
                BLASTS,
                CT_CYCLE,
                CT_STUDYDAY AS CT_STUDY_DAY,
                CT_PEAKTROUGH AS CT_PEAK_THROUGH,
                CT_TIMEPOSTDRUG AS CT_TIME_POST_DRUG,
                CT_TIMEPOSTDRUG_UNIT AS CT_TIME_POST_DRUG_UNIT,
                CT_TIMEINRELATIONTOTREATMENT AS CT_TREATMENT_RELATION_TIME,
                WHENMODIFIED AS WHEN_MODIFIED
            FROM HMTB_INVENTORY
            ORDER BY MEDRECNUM";
    }
}
