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
 * Import target interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ImportTargetInterface
{
    const ACTIVE = 1;
    const ACCEPTED = 2;
    const DECLINED = 3;

    /**
     * Set status.
     *
     * @param integer $status
     * @return ImportTargetInterface
     */
    public function setStatus($status);

    /**
     * Get status.
     *
     * @return integer
     */
    public function getStatus();

    /**
     * Set import subject.
     *
     * @param ImportSubjectInterface|null $subject
     * @return ImportTargetInterface
     */
    public function setImportSubject(ImportSubjectInterface $subject = null);

    /**
     * Get import subject.
     *
     * @return ImportSubjectInterface|null
     */
    public function getImportSubject();

    /**
     * Test for import subject presence.
     *
     * @return boolean
     */
    public function hasImportSubject();

    /**
     * Get all registered importers for descriptions.
     *
     * @return array
     */
    public function getRegisteredImporters();

    /**
     * Test if importer has been registered.
     *
     * @param string $importerName
     * @return boolean
     */
    public function hasImporter($importerName);

    /**
     * Register importer for descriptions.
     *
     * @param string $importerName
     * @return ImportTargetInterface
     */
    public function registerImporter($importerName);

    /**
     * Unregister importer for descriptions.
     *
     * @param string $importerName
     * @return ImportTargetInterface
     */
    public function unregisterImporter($importerName);

    /**
     * Get all descriptions.
     *
     * @return array
     */
    public function getDescriptions();

    /**
     * Get all descriptions for importer.
     *
     * @param string $importerName
     * @return array
     */
    public function getDescriptionsFor($importerName);

    /**
     * Test if descriptions exist for importer.
     *
     * @param string $importerName
     * @return boolean
     */
    public function hasDescriptions($importerName);

    /**
     * Add description for importer.
     *
     * @param string $importerName
     * @param string $description
     * @return ImportTargetInterface
     */
    public function addDescription($importerName, $description);

    /**
     * Clear descriptions for importer.
     *
     * @param string $importerName
     * @return ImportTargetInterface
     */
    public function clearDescriptions($importerName);
}
