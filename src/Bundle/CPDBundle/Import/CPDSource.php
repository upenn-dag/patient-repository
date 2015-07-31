<?php
namespace Accard\Bundle\CPDBundle\Import;

/**
 * CPD Source
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use DAG\Component\Prototype\Provider\PrototypeProviderInterface;
use Doctrine\DBAL\Connection;

class CPDSource implements SourceAdapterInterface
{
    /**
     * PDS connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * Diagnosis codes.
     *
     * @var array
     */
    private $codes;

    /**
     * Constructor.
     */
    public function __construct(
        Connection $connection,
        array $codes
    ) {
        $this->connection = $connection;
        $this->codes = $codes;
    }

    /**
     * Execute
     */
    public function execute(array $criteria = null)
    {
        $stmt = $this->connection->prepare($this->buildQuery());
        $stmt->execute();
        $results = $stmt->fetchAll();
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Build SQL query.
     *
     * @return string
     */
    private function buildQuery()
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
                FAF,
                EXON_ID,
                EXON
            FROM CPD.RESULTS_MVW
            WHERE TEST_DATE IS NOT NULL
            ORDER BY PATIENT_MRN";
    }
}
