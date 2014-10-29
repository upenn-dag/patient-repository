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

use DateTime;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\ActivityBundle\Import\ActivityImporter;
use Accard\Bundle\ResourceBundle\Import\ImporterInterface;
use Accard\Bundle\CoreBundle\Provider\ImportPatientProvider;
use Doctrine\DBAL\Connection;

/**
 * Genetic results importer.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class GeneticResultsImporter extends ActivityImporter
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

            $record['identifier'] = $result['cpd_id'];
            $result['import_description'] = sprintf('%s genetic results on the %s.', $result['cpd_id'], $result['patient']);
            $record = $resolver->resolve($result);

            if ($record['patient'] && $record['genetic_test_version_id'] == '2') {
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

        $mutations = array('substitution', 'deletion', 'missense', 'frameshift', 'deletion/insertion', 'insertion', 'duplication');

        $resolver->setRequired(array(
            'cpd_id',
            'gene',
            'variant_detected',
            'cdna_change',
            'mutation_type_cdna',
            'mutation_type_protein',
        ));

        $resolver->setOptional(array('protein_change', 'variant_categorization', 'variant_alias', 'genetic_test_version_id'));

        $resolver->setAllowedTypes(array(
            'cpd_id' => array('string'),
            'gene' => array('string'),
            'variant_detected' => array('string'),
            'variant_categorization' => array('string', 'null'),
            'cdna_change' => array('string'),
            'protein_change' => array('string', 'null'),
            'mutation_type_cdna' => array('string'),
            'mutation_type_protein' => array('string'),
            'variant_alias' => array('string', 'null'),
        ));

        $resolver->setAllowedValues(array(
            'variant_detected' => array('Yes', 'No'),
            'variant_categorization' => array('Pathogenic', 'VUS', 'Probably DA', 'Likely Benign', 'Benign', null),
            'variant_alias' => array('ITD', null),
            'mutation_type_cdna' => $mutations,
            'mutation_type_protein' => $mutations,
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
        return 'cpd_genetic_results';
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
                PK_ID AS CPD_ID,
                LPAD(PATIENT_MRN, 9, '0') AS PATIENT,
                CONCAT(LPAD(PATIENT_MRN, 9, '0'), GENE) AS IDENTIFIER,
                TO_CHAR(TEST_DATE, 'mm/dd/yyyy') AS ACTIVITY_DATE,
                GENE,
                VARIANT_DETECTED,
                VARIANT_CATEGORIZATION,
                CDNA_CHANGE,
                PROTEIN_CHANGE,
                MUTATION_TYPE_CDNA,
                MUTATION_TYPE_PROTEIN,
                VARIANT_ALIAS,
                GENETIC_TEST_VERSION_ID
            FROM CPD_VW_RESULTS
            WHERE TEST_DATE IS NOT NULL
            ORDER BY PATIENT_MRN";
    }
}
