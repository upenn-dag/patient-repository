<?php
namespace Accard\Bundle\RIDICBundle\Import;

/**
 * RIDIC \ Import \ RIDIC Source
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Doctrine\DBAL\Connection;

class RIDICSource implements SourceAdapterInterface
{
    /**
     * RIDIC connection.
     *
     * @var Connection
     */
    private $connection;

    /**
     * Constructor.
     */
    public function __construct(Connection $connection)
    {
    	$this->connection = $connection;
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
        die(var_dump($results));
        return $results;
    }

    /**
     * Build SQL query.
     *
     * @return string
     */
    private function buildQuery()
    {
        return "
            SELECT
            aria.v_COURSE_DOSE.COURSE_SER,
            REF_POINT_ID,
            REF_POINT_SER,
            RX_DAILY_DOSE,
            RX_FRACTIONS,
            RX_SESSION_DOSE,
            RX_TOTAL_DOSE,
            TREATED_FRACTIONS,
            TREATED_TOTAL_DOSE,
            DX_COMMENTS,
            DX_DESC,
            G,
            M,
            N,
            T,
            PSA,
            STAGE,
            STAGE_BASIS,
            ICD9_CODE,
            FIRST_TREATMENT_DT,
            LAST_TREATMENT_DT
            FROM aria.v_COURSE_DOSE
                JOIN aria.v_COURSE_PRIM_CA_DX
                ON aria.v_COURSE_DOSE.COURSE_SER = aria.v_COURSE_PRIM_CA_DX.COURSE_SER
                JOIN aria.TREATED_COURSES
                ON aria.v_COURSE_DOSE.COURSE_SER = aria.TREATED_COURSES.COURSE_SER;
        ";
    }
}