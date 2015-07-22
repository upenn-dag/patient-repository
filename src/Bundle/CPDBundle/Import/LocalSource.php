<?php
namespace Accard\Bundle\CPDBundle\Import;

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
		$prototype = $this->prototypeProvider->getPrototypeByName('genetic-results');
        $sql = $this->buildQuery($prototype);
        $stmt = $this->connection->prepare($sql);
        $stmt->execute();
		$localRecords = $this->prepareResults($stmt->fetchAll(), $prototype);
        $stmt->closeCursor();

        return $localRecords;
	}

	/**
	 * Query
	 */
	private function buildQuery($prototype)
	{
		$fieldIds = array();
        foreach ($prototype->getFields() as $field) {
            $fieldIds[] = $field->getId();
        }

        $sql = "SELECT a.id AS sampleId, a.patientId, v.fieldId, v.stringValue
            FROM accard_sample_proto_fldval v
            LEFT JOIN accard_sample a ON (v.sampleId = a.id)
            WHERE v.fieldId IN (%s)";

        return sprintf($sql, implode(', ', $fieldIds));
	}

	/**
	 * Prepare Local Results
	 */
    private function prepareResults(array $results, PrototypeInterface $prototype)
    {
        $localResults = array();
        foreach ($results as $key => $result) {
            $result = array_change_key_case($result, CASE_LOWER);
            $sampleId = $result['sampleid'];
            $fieldId = $result['fieldid'];
            if (!isset($localResults[$sampleId])) {
                $localResults[$sampleId] = array();
            }
            $localResults[$sampleId][$fieldId] = $result['stringvalue'];

            unset($results[$key]);
        }

        unset($results);

        $fields = array(
            $prototype->getFieldByName('genetic-results-cpd-id'),
            $prototype->getFieldByName('genetic-results-gene-id'),
            $prototype->getFieldByName('genetic-results-transcript-id'),
            $prototype->getFieldByName('genetic-results-position'),
            $prototype->getFieldByName('genetic-results-genotype'),
            $prototype->getFieldByName('genetic-results-fdp'),
            $prototype->getFieldByName('genetic-results-frd'),
            $prototype->getFieldByName('genetic-results-fad'),
            $prototype->getFieldByName('genetic-results-faf')
        );

        // Turn this into an array like;
        // array('MyConcatIdForComparison', 'SomeOtherCocatenation');

        $concatenatedLocalRecords = $this->compileLocalRecords($localResults, $fields);
        return $concatenatedLocalRecords;
    }

    /**
     * Since CPD's view has a composite key as a primary we need to concantenate local records to recreate the key
     */
    private function compileLocalRecords(array $localResults, array $fields)
    {
        $concatenatedLocalRecords = array();

        foreach($localResults as $localResult) {
            $concatenatedId = '';
            foreach($fields as $field) {
                if(isset($localResult[$field->getId()]))
                {
                    $concatenatedId .= $localResult[$field->getId()];
                }
            }
            $concatenatedLocalRecords[] = $concatenatedId;
        }

        unset($localResults);
        unset($fields);

        return $concatenatedLocalRecords;
    }

}