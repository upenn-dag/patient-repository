<?php
namespace Accard\Bundle\HMTBBundle\Import;

/**
 * HMTB Source
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use DAG\Component\Prototype\Provider\PrototypeProviderInterface;
use Doctrine\DBAL\Connection;

class HMTBSource implements SourceAdapterInterface
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
    public function __construct(Connection $connection,
    							array $codes)
    {
    	$this->connection = $connection;
    	$this->codes = $codes;
    }

    /**
     * Execute
     */
    public function execute(array $criteria = null)
    {
        $stmt = $this->connection->prepare($this->buildQuery());
        $stmt->execute(array(
            'first_id' => $criteria['first_id'],
            'last_id' => $criteria['last_id'],
        ));

        $results = $stmt->fetchAll();
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Get SQL statement.
     *
     * @return string
     */
    private function buildQuery()
    {
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
            FROM HMTB.INVENTORY_VW
            WHERE COLLECTION_ID > :first_id AND COLLECTION_ID <= :last_id
            ORDER BY MEDRECNUM";
    }
}