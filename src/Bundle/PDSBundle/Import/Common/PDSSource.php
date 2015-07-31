<?php
namespace Accard\Bundle\PDSBundle\Import\Common;

/**
 * PDS \ Import \ Common \ Source
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;

abstract class PDSSource implements SourceAdapterInterface
{

    /**
     * Execute
     *
     * @param array || null $criteria
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
}
