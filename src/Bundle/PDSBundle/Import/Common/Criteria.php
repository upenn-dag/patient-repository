<?php
namespace Accard\Bundle\PDSBundle\Import\Common;

/**
 * PDS \ Import \ Common \ Criteria
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\CriteriaInterface;
use Accard\Bundle\ResourceBundle\Doctrine\ORM\ImportRepository;
use Doctrine\DBAL\Connection;
use PDO;
use DateTime;

class Criteria implements CriteriaInterface
{
    /**
     * Default start date.
     *
     * @var DateTime
     */
    private $defaultStartDate;

    /**
     * History.
     * 
     * @var history.
     */
    private $history;

    /**
     * Constructor.
     */
    public function __construct($defaultStartDate = null)
    {
        $this->defaultStartDate = $defaultStartDate ? new DateTime($defaultStartDate) : new DateTime('1 month ago');
    }

    /**
     * Calculate criteria.
     * 
     * @param array $history.
     */
    public function calculate(array $history = null)
    {
        if (empty($history)) {
            return;
        }

        $criteria = $history[0]->getCriteria();

        return array(
            'start_date' => $criteria['end_date'],
            'end_date' => new DateTime(),
        );
    }

	/**
	 * Retrieve criteria.
     *
     *  @return array $params 
	 */
	public function retrieve()
	{  
        return $this->params;
	} 

    /**
     * Retrieve default criteria.
     */
    public function retrieveDefault()
    {
        return array(
            'start_date' => $this->defaultStartDate,
            'end_date' => new DateTime(),
        );
    }

    /**
     * Set criteria parameters.
     * 
     * @param array $criteria
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Get criteria parameters.
     * 
     * @return array $params.
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set history.
     */
    public function setHistory($history)
    {
        $this->history = $history;
    }

    /**
     * Get history.
     */
    public function getHistory()
    {
        return $this->history;
    }

}