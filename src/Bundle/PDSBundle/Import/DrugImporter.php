<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PDSBundle\Import;

use DateTime;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\PatientBundle\Import\PatientImporter;
use Accard\Bundle\PatientBundle\Exception\PatientNotFoundException;
use Accard\Bundle\CoreBundle\Provider\ImportPatientProvider;
use Doctrine\DBAL\Connection;

/**
 * Drug importer.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugImporter extends PatientImporter
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
     * Drugs.
     *
     * @var array
     */
    private $drugs;

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
     * @param array $drugs
     * @param string|null $defaultStartDate
     */
    public function __construct(ImportPatientProvider $provider,
                                Connection $connection,
                                array $drugs,
                                $defaultStartDate = null)
    {
        $this->provider = $provider;
        $this->connection = $connection;
        $this->drugs = $drugs;
        $this->defaultStartDate = $defaultStartDate ? new DateTime($defaultStartDate) : new DateTime('1 month ago');
    }

    /**
     * {@inheritdoc}
     */
    public function run(OptionsResolverInterface $resolver, array $criteria)
    {
        $records = array();
        $stmt = $this->connection->prepare($this->getSQL());
        $stmt->execute(array(
            'mds' => $criteria['start_date']->format('m/d/Y'),
            'mde' => $criteria['end_date']->format('m/d/Y'),
        ));
        $results = $stmt->fetchAll();
        $stmt->closeCursor();
        $cache = array();

        foreach ($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);

            try {
                if ($record = $this->provider->getPatientByMRN($result['mrn'])) {
                    $result['previous_record'] = $record;
                }
            } catch (PatientNotFoundException $e) {}

            $result['identifier'] = $result['mrn'];
            $result['import_description'] = sprintf('%s ordered on %s.', $result['medication'], $result['medication_date']);

            unset($result['medication'], $result['medication_date']);
            $records[] = $resolver->resolve($result);
            unset($results[$key]);
        }

        return $records;
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteria(array $history)
    {
        if (empty($history)) {
            return;
        }

        $criteria = $history[0]->getCriteria();

        return array(
            'start_date' => $criteria['end_date'],
            'end_date' => new DateTime(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultCriteria()
    {
        return array(
            'start_date' => $this->defaultStartDate,
            'end_date' => new DateTime(),
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'pds_drug';
    }

    private function getSQL()
    {
        $drugs = implode(', ', $this->drugs);

        return "SELECT
            MRN,
            MEDICATION,
            MEDICATION_DATE,
            FIRST_NAME,
            LAST_NAME,
            GENDER,
            /*RACE,*/
            DATE_OF_BIRTH,
            DATE_OF_DEATH
        FROM (SELECT
                LPAD(MP.HUP_MRN, 9, 0) AS MRN,
                M1.FULL_NAME AS MEDICATION,
                TO_CHAR(O.ORDER_DATE, 'mm/dd/yyyy') AS MEDICATION_DATE,
                MP.PATIENT_FNAME AS FIRST_NAME,
                MP.PATIENT_LNAME AS LAST_NAME,
                MP.GENDER_CODE AS GENDER,
                MP.RACE_CODE AS RACE,
                TO_CHAR(MP.BIRTH_DATE, 'mm/dd/yyyy') AS DATE_OF_BIRTH,
                TO_CHAR(MP.DECEASED_DATE, 'mm/dd/yyyy') AS DATE_OF_DEATH
            FROM PDS_ODS_ORDERS O
                INNER JOIN PDS_ODS_ENCOUNTER E ON E.PK_ENCOUNTER_ID = O.FK_ENCOUNTER_ID
                INNER JOIN PDS_ODS_PATIENT P ON P.PK_PATIENT_ID = E.FK_PATIENT_ID
                INNER JOIN PDS_MDM_PATIENT MP ON MP.PK_PATIENT_ID = P.MDM_PATIENT_ID
                INNER JOIN PDS_ODS_ORDER_MED M ON M.FK_ORDER_ID = O.PK_ORDER_ID
                INNER JOIN PDS_ODS_R_MEDICATION M1 ON M1.PK_MEDICATION_ID = M.FK_MEDICATION_ID
            AND O.ORDER_DATE > TO_DATE(:mds, 'mm/dd/yyyy')
            AND O.ORDER_DATE < TO_DATE(:mde, 'mm/dd/yyyy')
            AND MP.HUP_MRN IS NOT NULL
            AND M1.PK_MEDICATION_ID IN ({$drugs})
        )
        GROUP BY MRN, MEDICATION, MEDICATION_DATE, FIRST_NAME, LAST_NAME, GENDER, RACE, DATE_OF_BIRTH, DATE_OF_DEATH
        ORDER BY MRN, MEDICATION_DATE";
    }
}
