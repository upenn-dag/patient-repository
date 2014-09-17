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

/**
 * Import target trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait ImportTargetTrait
{
    /**
     * Import status.
     *
     * @var integer
     */
    protected $status = ImportTargetInterface::ACTIVE;

	/**
	 * Import subject.
	 *
	 * @var ImportSubjectInterface|null
	 */
	protected $subject;

    /**
     * Importer descriptions.
     *
     * @var array
     */
    protected $descriptions = array();


    /**
     * {@inheritdoc}
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * {@inheritdoc}
     */
    public function setImportSubject(ImportSubjectInterface $subject = null)
    {
    	$this->subject = $subject;

    	return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getImportSubject()
    {
    	return $this->subject;
    }

    /**
     * {@inheritdoc}
     */
    public function hasImportSubject()
    {
    	return $this->subject instanceof ImportSubjectInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function getRegisteredImporters()
    {
        return array_keys($this->descriptions);
    }

    /**
     * {@inheritdoc}
     */
    public function hasImporter($importerName)
    {
        return isset($this->descriptions[$importerName]);
    }

    /**
     * {@inheritdoc}
     */
    public function registerImporter($importerName)
    {
        if (!isset($this->descriptions[$importerName])) {
            $this->descriptions[$importerName] = array();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function unregisterImporter($importerName)
    {
        unset($this->descriptions[$importerName]);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescriptions()
    {
        return $this->descriptions;
    }

    /**
     * {@inheritdoc}
     */
    public function getDescriptionsFor($importerName)
    {
        if ($this->hasImporter($importerName)) {
            return $this->descriptions[$importerName];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function hasDescriptions($importerName)
    {
        if ($this->hasImporter($importerName) && count($this->descriptions[$importerName])) {
            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function addDescription($importerName, $description)
    {
        if (!$this->hasImporter($importerName)) {
            $this->registerImporter($importerName);
        }

        $this->descriptions[$importerName][] = $description;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function clearDescriptions($importerName)
    {
        if ($this->hasImporter($importerName)) {
            $this->descriptions[$importerName] = array();
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function mergeDescriptions(array $descriptions)
    {
        $this->descriptions = array_merge_recursive($this->descriptions, $descriptions);
    }
}
