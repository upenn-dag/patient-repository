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
        return "SELECT
            *
            FROM ARIA.V_COURSE_DOSE";
    }
}