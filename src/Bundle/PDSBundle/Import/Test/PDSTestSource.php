<?php
namespace Accard\Bundle\PDSBundle\Import\Test;

/**
 * PDS \ Import \ Source \ Test Source
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use Accard\Bundle\PDSBundle\Import\Common\PDSSource;
use DAG\Component\Prototype\Provider\PrototypeProviderInterface;
use Doctrine\DBAL\Connection;

class PDSTestSource extends PDSSource implements SourceAdapterInterface
{
    /**
     * PDS connection.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * Diagnosis tests.
     *
     * @var array
     */
    protected $tests;

    /**
     * Constructor.
     */
    public function __construct(Connection $connection,
    							array $tests)
    {
    	$this->connection = $connection;
    	$this->tests = $tests;
    }

	/**
	 * Build query
	 *
	 * @return string
	 */
    protected function buildQuery()
    {
        $tests = implode(', ', $this->tests);

        return "SELECT
                MRN,
                RESULT,
                RESULT_DATE,
                FIRST_NAME,
                LAST_NAME,
                GENDER,
                /*RACE,*/
                DATE_OF_BIRTH,
                DATE_OF_DEATH
            FROM(
                SELECT
                    LPAD(MP.HUP_MRN,9,0) AS MRN,
                    RT.RESULT_ITEM_CODE AS RESULT,
                    TO_CHAR(O.ORDER_DATE, 'mm/dd/yyyy') AS RESULT_DATE,
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
                     INNER JOIN PDS_ODS_ORDER_RESULT RE ON RE.FK_ORDER_ID = O.PK_ORDER_ID
                     INNER JOIN PDS_ODS_R_RESULT_ITEM RT ON RT.PK_RESULT_ITEM_ID = RE.FK_RESULT_ITEM_ID
                AND O.ORDER_DATE > TO_DATE(:mds, 'mm/dd/yyyy')
                AND RE.RESULT_DATE > TO_DATE(:mds, 'mm/dd/yyyy')
                AND O.ORDER_DATE < TO_DATE(:mde, 'mm/dd/yyyy')
                AND RE.RESULT_DATE < TO_DATE(:mde, 'mm/dd/yyyy')
                AND RT.PK_RESULT_ITEM_ID IN ({$tests})
                AND MP.HUP_MRN IS NOT NULL
            )
            GROUP BY MRN, RESULT, RESULT_DATE, FIRST_NAME, LAST_NAME, GENDER, RACE, DATE_OF_BIRTH, DATE_OF_DEATH
            ORDER BY MRN, RESULT_DATE";
    }
}