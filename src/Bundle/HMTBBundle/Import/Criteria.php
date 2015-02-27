<?php
namespace Accard\Bundle\HMTBBundle\Import;

/**
 * HMTB \ Import \ Criteria
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\CriteriaInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\ImportRepository;
use Doctrine\DBAL\Connection;
use PDO;

class Criteria implements CriteriaInterface
{
	/**
	 * PDS connection.
	 */
	protected $connection;

    /**
     * Import repository.
     */
    protected $repository;

	/**
	 * Constructor.
	 */
	public function __construct(Connection $connection,
                                ImportRepository $repository)
	{
		$this->connection = $connection;
        $this->repository = $repository;
	}

    /**
     * Get local last id
     * 
     * @return string $id
     */
    public function getLastLocalId()
    {
        $latestImport = $this->repository->getLatestFor('hmtb_specimens_collection');

        if(is_null($latestImport)) {
            return 0;
        }

        $localLastCriteria = $latestImport->getCriteria();

        return $localLastCriteria['last_id'];
    }

    /**
     * Get HMTB last id
     * 
     * @return string $id
     */
    public function getLastHMTBId()
    {
        $stmt = $this->connection->prepare($this->getMaxCollectionId());
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $lastId = $result['MAX'];
        $stmt->closeCursor();

        return $lastId;
    }



	/**
	 * Retrieve criteria
	 */
	public function retrieve(array $history = null)
	{  
        $lastHMTBId = $this->getLastHMTBId();
        $lastLocalId = $this->getLastLocalId();

        return array(
            'first_id' => $lastLocalId,
            'last_id' => $lastHMTBId,
        );
	}

    /**
     * Does the criteria pass?
     * 
     * @desc if the criteria fails, then the importer needs to run
     * @return boolean
     */
    public function passes()
    {
        $criteria = $this->retrieve();

        if ($criteria['first_id'] == $criteria['last_id']) {
            return false;
        }

        return true;
    }

    /**
     * Find the biggest collection id SQL.
     * 
     * @return string
     */
    private function getMaxCollectionId()
    {
        return "SELECT MAX(COLLECTION_ID) AS MAX FROM HMTB.INVENTORY_VW";
    }
}