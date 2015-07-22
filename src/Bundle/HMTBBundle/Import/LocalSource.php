<?php
namespace Accard\Bundle\HMTBBundle\Import;

/**
 * Local Source Adapter
 *
 * @desc Responsible for knowing how to get local records
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use DAG\Bundle\ResourceBundle\Import\SourceAdapterInterface;
use DAG\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Sample\Model\PrototypeInterface;
use Doctrine\DBAL\Connection;

class LocalSource implements SourceAdapterInterface
{
	/**
	 * Connection
	 */
	protected $connection;

	/**
	 * Prototype Provider
	 */
	protected $provider;

	/**
	 * Constructor
	 */
	public function __construct(Connection $connection,
								PrototypeProviderInterface $prototypeProvider)
	{
		$this->connection = $connection;
		$this->prototypeProvider = $prototypeProvider;
	}

	/**
	 * Execute Command
	 */
	public function execute(array $criteria = null)
	{
		$prototype = $this->prototypeProvider->getPrototypeByName('specimen-collection');
		$sql = $this->buildQuery($prototype);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
        $localRecords = $stmt->fetchAll();
        $stmt->closeCursor();

        //Cleansing localRecords to a simple array of htmb-ids that are existant in the local database
        $hmtbIds = array();
        foreach($localRecords as $localRecord) {
            $hmtbIds[] = $localRecord['stringValue'];
        }

        return $localRecords;
	}


    /**
     * {@inheritdoc}
     */
    private function buildQuery(PrototypeInterface $prototype)
    {
        /**
         * Need to get all hmtb id's that are stored locally.
         */
        $hmtbFieldId = $prototype->getFieldByName('hmtb-id')->getId();

        $sql = "SELECT v.stringValue
            FROM accard_sample_proto_fldval AS v
            LEFT JOIN accard_sample AS a ON (v.sampleId = a.id)
            WHERE v.fieldId IN (%s)";

        return sprintf($sql, $hmtbFieldId);
    }
}