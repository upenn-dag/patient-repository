<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Event;

use Symfony\Component\EventDispatcher\Event;
use Accard\Component\Resource\Model\Import;
use Accard\Component\Resource\Model\ImportInterface;
use Accard\Bundle\ResourceBundle\Import\ResourceInterface;
use Accard\Bundle\ResourceBundle\Import\ImporterInterface;
use Accard\Bundle\ResourceBundle\Exception\ImporterAccessException;
use Accard\Bundle\ResourceBundle\Exception\DuplicateImporterException;
use Accard\Bundle\ResourceBundle\Exception\ResourceNotSubjectException;
use Accard\Bundle\ResourceBundle\Exception\ResourceNotTargetException;

/**
 * Import event.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportEvent extends Event
{
    /**
     * Subject resource.
     *
     * @var ResourceInterface
     */
    protected $subject;

    /**
     * Target resource.
     *
     * @var ResourceInterface
     */
    protected $target;

    /**
     * Importer.
     *
     * @var ImporterInterface
     */
    protected $importer;

    /**
     * Import entity.
     *
     * @var ImportInterface
     */
    protected $import;

    /**
     * Import history.
     *
     * @var ResourceInterface
     */
    protected $history;

    /**
     * Records.
     *
     * @var array
     */
    protected $records;


    /**
     * Constructor.
     *
     * @param ImporterInterface $importer
     */
    public function __construct(ResourceInterface $subject,
                                ResourceInterface $target,
                                $import = null)
    {
        if (!$subject->isSubject()) {
            die(var_dump($subject));
            throw new ResourceNotSubjectException($subject);
        }

        if (!$target->isTarget()) {
            throw new ResourceNotTargetException($target);
        }

        $this->subject = $subject;
        $this->target = $target;
        $this->import = $import ?: new Import();
    }

    /**
     * Get subject resource.
     *
     * @return ResourceInterface
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Get target resource.
     *
     * @return ResourceInterface
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * Set importer.
     *
     * @param ImporterInterface|null $importer
     */
    public function setImporter(ImporterInterface $importer = null)
    {
        $this->importer = $importer;
    }

    /**
     * Get importer.
     *
     * @return ImporterInterface
     */
    public function getImporter()
    {
        return $this->importer;
    }

    /**
     * Get import.
     *
     * @return ImportInterface
     */
    public function getImport()
    {
        return $this->import;
    }

    /**
     * Set history.
     *
     * @param array|ImportInterface[] $history
     */
    public function setHistory(array $history)
    {
        $this->history = $history;
    }

    /**
     * Get history.
     *
     * @return array|ImportInterface[]
     */
    public function getHistory()
    {
        return $this->history;
    }

    /**
     * Set records.
     *
     * @param array $records
     */
    public function setRecords(array $records = null)
    {
        $this->records = $records;
    }

    /**
     * Get records.
     *
     * @return array
     */
    public function getRecords()
    {
        return $this->records;
    }
}
