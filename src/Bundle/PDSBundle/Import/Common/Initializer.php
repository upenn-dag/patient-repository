<?php
namespace Accard\Bundle\PDSBundle\Import\Common;

/**
 * PDS \ Import \ Common \ Initializer
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Event\ImportEvent;
use DAG\Bundle\ResourceBundle\Import\CriteriaInterface;
use DAG\Bundle\ResourceBundle\Import\InitializerInterface;

class Initializer implements InitializerInterface
{
	/**
	 * Criteria
	 */
	protected $criteria;

	/**
	 * Constructor.
	 */
	public function __construct(CriteriaInterface $criteria)
	{
		$this->criteria = $criteria;
	}

	/**
     * Initialize the import object.
     *
     * Figure out criteria to use...
     *
     * @param ImportEvent $event
     */
    public function initialize(ImportEvent $event)
    {
        $import = $event->getImport();
        $history = $event->getHistory();
        $importer = $event->getImporter();
        $criteria = array();

        if (empty($history)) {
            $criteria = $this->criteria->setParams($this->criteria->retrieveDefault());
        }

        if (empty($criteria)) {
            $criteria = $this->criteria->setParams($this->criteria->calculate($history));
        }

        $import->setImporter($importer->getName());
        $import->setCriteria($criteria->retrieve());
    }
}