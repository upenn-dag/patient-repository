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
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Prototype\Model\PrototypeInterface;
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
     * Local connection.
     * 
     * @var Connection
     */
    private $defaultConnection;

    /**
     * Prototype provider.
     * 
     * @var PrototypeProviderInterface
     */
    private $prototypeProvider;

    /**
     * Diagnosis codes.
     *
     * @var array
     */
    private $codes;


    /**
     * Constructor.
     *
     * @param ImportPatientProvider $provider
     * @param Connection $connection
     * @param Connection $defaultConnection
     * @param array $code
     * @param PrototypeProviderInterface $prototypeProvider
     * @param string|null $defaultStartDate
     */
    public function __construct(ImportPatientProvider $provider,
                                Connection $connection,
                                Connection $defaultConnection,
                                PrototypeProviderInterface $prototypeProvider,
                                array $codes)
    {
        $this->provider = $provider;
        $this->connection = $connection;
        $this->defaultConnection = $defaultConnection;
        $this->prototypeProvider = $prototypeProvider;
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

        $prototype = $this->prototypeProvider->getPrototypeByName('genetic-results');
        $sql = $this->getHasFieldSQL($prototype);
        $stmt = $this->defaultConnection->prepare($sql);
        $stmt->execute();

        $localRecords = $this->fixLocalResults($stmt->fetchAll(), $prototype);
        $stmt->closeCursor();  

        foreach($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);

            try {
                $result['previous_record'] = $this->provider->getPatientByMRN($result['patient']);
            } catch (PatientNotFoundException $e) {
                unset($result, $results[$key]);
                continue;
            }

            $record['identifier'] = $result['pk_id'];
            $result['import_description'] = sprintf('%s genetic results on the %s.', $result['cpd_id'], $result['patient']);
            $record = $resolver->resolve($result);

            if($record['patient'] && $record['genetic_test_version_id'] == '2' && !in_array($record['pk_id'], $localRecords)) {
                $records[] = $record;
            }
            unset($results[$key]);
        }
        unset($localRecords);

        return $records;
    }

    private function concatenateLocalRecords(array $localResults, array $fields)
    {
        $concatenatedLocalRecords = array();

        foreach($localResults as $localResult)
        {
            $concatenatedId = '';
            foreach($fields as $field)
            {
                if(isset($localResult[$field->getId()]))
                {
                    $concatenatedId .= $localResult[$field->getId()];
                }
            }
            $concatenatedLocalRecords[] = $concatenatedId;
        }

        unset($localResults);
        unset($fields);

        return $concatenatedLocalRecords;
    }

    private function fixLocalResults(array $results, PrototypeInterface $prototype)
    {
        $localResults = array();
        foreach ($results as $key => $result) {
            $activityId = $result['activityId'];
            $fieldId = $result['fieldId'];
            if (!isset($localResults[$activityId])) {
                $localResults[$activityId] = array();
            }
            $localResults[$activityId][$fieldId] = $result['stringValue'];

            unset($results[$key]);
        }

        unset($results);

        $fields = array(
            $prototype->getFieldByName('genetic-results-cpd-id'),
            $prototype->getFieldByName('genetic-results-gene-id'),
            $prototype->getFieldByName('genetic-results-transcript-id'),
            $prototype->getFieldByName('genetic-results-position'),
            $prototype->getFieldByName('genetic-results-genotype'),
            $prototype->getFieldByName('genetic-results-fdp'),
            $prototype->getFieldByName('genetic-results-frd'),
            $prototype->getFieldByName('genetic-results-fad'),
            $prototype->getFieldByName('genetic-results-faf')
        );

        // Turn this into an array like;
        // array('MyConcatIdForComparison', 'SomeOtherCocatenation');

        $concatenatedLocalRecords = $this->concatenateLocalRecords($localResults, $fields);
        return $concatenatedLocalRecords;
    }

    private function getHasFieldSQL(PrototypeInterface $prototype)
    {
        $fieldIds = array();
        foreach ($prototype->getFields() as $field) {
            $fieldIds[] = $field->getId();
        }

        $sql = "SELECT a.id AS activityId, a.patientId, v.fieldId, v.stringValue
            FROM accard_activity_proto_fldval AS v
            LEFT JOIN accard_activity AS a ON (v.activity_prototypeId = a.id)
            WHERE v.fieldId IN (%s)";

        return sprintf($sql, implode(', ', $fieldIds));
    }

    /**
     * {@inheritdoc}
     */
    public function configureResolver(OptionsResolverInterface $resolver)
    {
        parent::configureResolver($resolver);

        $mutations = array('substitution', 'deletion', 'missense', 'frameshift', 'deletion/insertion', 'insertion', 'duplication');

        $resolver->setRequired(array(
            'pk_id',
            'cpd_id',
            'gene',
            'gene_id',
            'variant_detected',
            'cdna_change',
            'mutation_type_cdna',
            'mutation_type_protein'
        ));

        $resolver->setOptional(array(
            'protein_change',
            'variant_categorization', 
            'variant_alias', 
            'genetic_test_version_id',
            'transcript_id',
            'position',
            'fdp',
            'frd',
            'fad',
            'faf',
            'genotype'
        ));

        $resolver->setAllowedTypes(array(
            'pk_id' => array('string'),
            'cpd_id' => array('string'),
            'gene' => array('string'),
            'gene_id' => array('string', 'null'),
            'variant_detected' => array('string'),
            'variant_categorization' => array('string', 'null'),
            'cdna_change' => array('string'),
            'protein_change' => array('string', 'null'),
            'mutation_type_cdna' => array('string'),
            'mutation_type_protein' => array('string'),
            'variant_alias' => array('string', 'null'),
            'transcript_id' => array('string', 'null'),
            'position' => array('string', 'null'),
            'fdp' => array('string', 'null'),
            'frd' => array('string', 'null'),
            'fad' => array('string', 'null'),
            'faf' => array('string', 'null'),
            'genotype' => array('string', 'null'),
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
                CPD_ID,
                PK_ID,
                LPAD(PATIENT_MRN, 9, '0') AS PATIENT,
                CONCAT(LPAD(PATIENT_MRN, 9, '0'), GENE) AS IDENTIFIER,
                TO_CHAR(TEST_DATE, 'mm/dd/yyyy') AS ACTIVITY_DATE,
                GENE,
                GENE_ID,
                VARIANT_DETECTED,
                VARIANT_CATEGORIZATION,
                CDNA_CHANGE,
                PROTEIN_CHANGE,
                MUTATION_TYPE_CDNA,
                MUTATION_TYPE_PROTEIN,
                VARIANT_ALIAS,
                GENETIC_TEST_VERSION_ID,
                TRANSCRIPT_ID,
                POSITION,
                GENOTYPE,
                FDP,
                FRD,
                FAD,
                FAF
            FROM CPD_VW_RESULTS
            WHERE TEST_DATE IS NOT NULL
            ORDER BY PATIENT_MRN";
    }
}
