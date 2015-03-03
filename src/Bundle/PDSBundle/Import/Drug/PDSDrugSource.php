<?php
namespace Accard\Bundle\PDSBundle\Import\Drug;

/**
 * PDS \ Import \ Drug \ PDS Source
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use Accard\Bundle\PDSBundle\Import\Common\PDSSource;
use Doctrine\DBAL\Connection;

class PDSDrugSource extends PDSSource implements SourceAdapterInterface
{
    /**
     * PDS connection.
     *
     * @var Connection
     */
    protected $connection;

    /**
     * Drugs.
     *
     * @var array
     */
    protected $drugs;

    /**
     * Constructor.
     */
    public function __construct(Connection $connection,
    							array $drugs)
    {
    	$this->connection = $connection;
    	$this->drugs = $drugs;
    }

	/**
	 * Build query.
	 *
	 * @return string
	 */
    protected function buildQuery()
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
                INNER JOIN PDS_ODS_R_LOCATION L ON L.PK_LOCATION_ID = E.FK_LOCATION_ID
            WHERE O.ORDER_DATE > TO_DATE(:mds, 'mm/dd/yyyy')
                AND O.ORDER_DATE < TO_DATE(:mde, 'mm/dd/yyyy')
                AND MP.HUP_MRN IS NOT NULL
                AND M1.PK_MEDICATION_ID IN ({$drugs})
                AND L.PK_LOCATION_ID IN (273036, 274036, 275034, 275036, 58712, 66359, 68359)
        )
        GROUP BY MRN, MEDICATION, MEDICATION_DATE, FIRST_NAME, LAST_NAME, GENDER, RACE, DATE_OF_BIRTH, DATE_OF_DEATH
        ORDER BY MRN, MEDICATION_DATE";
    }
}