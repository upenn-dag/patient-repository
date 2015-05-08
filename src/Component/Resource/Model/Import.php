<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Model;
use DateInterval;

/**
 * Import model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Import implements ImportInterface
{
    /**
     * Import id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Active status.
     *
     * @var boolean
     */
    protected $active;

    /**
     * Start timestamp.
     *
     * @var float
     */
    protected $startTimestamp;

    /**
     * End timestamp.
     *
     * @var float
     */
    protected $endTimestamp;

    /**
     * Importer name.
     *
     * @var string
     */
    protected $importer;

    /**
     * Criteria array.
     *
     * @var array
     */
    protected $criteria;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->startTimestamp = microtime(true);
        $this->criteria = array();
        $this->active = true;
    }

    /**
     * Get import id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    
    public function isActive()
    {
        return $this->active;
    }
    

    /**
     * {@inheritdoc}
     */
    public function setActive($active = true)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStartTimestamp()
    {
        return $this->startTimestamp;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndTimestamp()
    {
        return $this->endTimestamp;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndTimestamp($endTimestamp = null)
    {
        $this->endTimestamp = $endTimestamp ?: microtime(true);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDuration()
    {
        $endTimestamp = $this->endTimestamp ?: microtime(true);

        return $endTimestamp - $this->startTimestamp;
    }

    /**
     * {@inheritdoc}
     */
    public function getDurationAsInterval()
    {
        return new DateInterval('PT'.round($this->getDuration()).'S');
    }

    /**
     * {@inheritdoc}
     */
    public function getImporter()
    {
        return $this->importer;
    }

    /**
     * {@inheritdoc}
     */
    public function setImporter($importer)
    {
        $this->importer = $importer;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCriteria()
    {
        return $this->criteria;
    }
    
    /**
     * {@inheritdoc}
     */
    public function setCriteria(array $criteria)
    {
        $this->criteria = $criteria;

        return $this;
    }
}
