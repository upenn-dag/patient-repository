<?php
namespace Accard\Bundle\RIDICBundle\Import;

/**
 * RIDIC \ Import \ RIDIC Source
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use DAG\Component\Prototype\Provider\PrototypeProviderInterface;
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
        return $results;

    }

    /**
     * Build SQL query.
     *
     * @return string
     */
    private function buildQuery()
    {
        return "SELECT *
        FROM ext_object.ARIA_V_COURSE_DOSE D JOIN ext_object.ARIA_V_COURSE_PRIM_CA_DX P
        ON D.COURSE_SER = P.COURSE_SER
        JOIN ext_object.ARIA_TREATED_COURSES T ON D.COURSE_SER = T.COURSE_SER";
    }
}