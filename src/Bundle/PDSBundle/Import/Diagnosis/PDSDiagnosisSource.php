<?php
namespace Accard\Bundle\PDSBundle\Import\Diagnosis;

/**
 * PDS \ Import \ Diagnosis \ Source
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Doctrine\DBAL\Connection;

class PDSDiagnosisSource implements SourceAdapterInterface
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
            'mds' => $criteria['start_date']->format('m/d/Y'),
            'mde' => $criteria['end_date']->format('m/d/Y'),
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
        $codes = "'" . implode("', '", $this->codes) . "'";

        return "SELECT
                MRN,
                TO_CHAR(DIAGNOSIS_DATE, 'mm/dd/yyyy') AS DIAGNOSIS_DATE,
                DIAGNOSIS,
                FIRST_NAME,
                LAST_NAME,
                GENDER,
                TO_CHAR(DATE_OF_BIRTH, 'mm/dd/yyyy') AS DATE_OF_BIRTH,
                TO_CHAR(DATE_OF_DEATH, 'mm/dd/yyyy') AS DATE_OF_DEATH
            FROM (SELECT
                    LPAD(MP.HUP_MRN, 9, 0) AS MRN,
                    DX.CODING_DATE AS DIAGNOSIS_DATE,
                    CD.CODE AS DIAGNOSIS,
                    MP.PATIENT_FNAME AS FIRST_NAME,
                    MP.PATIENT_LNAME AS LAST_NAME,
                    MP.GENDER_CODE AS GENDER,
                    MP.BIRTH_DATE AS DATE_OF_BIRTH,
                    MP.DECEASED_DATE AS DATE_OF_DEATH,
                    ROW_NUMBER() OVER (PARTITION BY MP.HUP_MRN ORDER BY DX.CODING_DATE) AS ROW_NUM
                FROM PDS_ODS_DIAGNOSIS DX
                INNER JOIN PDS_ODS_ENCOUNTER E ON E.PK_ENCOUNTER_ID = DX.FK_ENCOUNTER_ID
                INNER JOIN PDS_ODS_R_CODES_DIAGNOSIS CD on CD.PK_DX_CODE_ID = DX.FK_DX_CODE_ID
                INNER JOIN PDS_ODS_PATIENT P  on P.PK_PATIENT_ID = E.FK_PATIENT_ID
                INNER JOIN PDS_MDM_PATIENT mp on MP.PK_PATIENT_ID = P.MDM_PATIENT_ID
                WHERE CD.CODE IN ({$codes})
                  AND DX.CODING_DATE > TO_DATE(:mds, 'mm/dd/yyyy')
                  AND E.ENC_DATE > TO_DATE(:mds, 'mm/dd/yyyy')
                  AND DX.CODING_DATE < TO_DATE(:mde, 'mm/dd/yyyy')
                  AND E.ENC_DATE < TO_DATE(:mde, 'mm/dd/yyyy')
                  AND MP.HUP_MRN IS NOT NULL
                  AND E.SOURCE_CODE IN ('HDMHUP', 'HDMPMC', 'CLINTRAC', 'EPIC')
            )
            WHERE ROW_NUM = 1
            ORDER BY MRN, DIAGNOSIS_DATE";
    }
}