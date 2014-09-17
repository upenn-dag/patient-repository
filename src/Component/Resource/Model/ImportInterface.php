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
 * Import interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ImportInterface
{
    /**
     * Get active.
     *
     * @return boolean
     */
    public function isActive();

    /**
     * Set active status.
     *
     * @param boolean $active
     * @return ImportInterface
     */
    public function setActive($active = true);

    /**
     * Get start time in seconds.
     *
     * @return integer
     */
    public function getStartTimestamp();

    /**
     * Get end time in seconds.
     *
     * @return integer
     */
    public function getEndTimestamp();

    /**
     * Set end timestamp in seconds.
     *
     * If no timestamp is provided, the current microtime will be used.
     *
     * @param float|null
     * @return ImportInterface
     */
    public function setEndTimestamp($endTimestamp = null);

    /**
     * Get amount of time spent running in seconds.
     *
     * @return integer
     */
    public function getDuration();

    /**
     * Get time spent as a DateInterval.
     *
     * @return DateInterval
     */
    public function getDurationAsInterval();

    /**
     * Get name of importer.
     *
     * @return string
     */
    public function getImporter();

    /**
     * Set name of importer.
     *
     * @param string $importer
     * @return ImportInterface
     */
    public function setImporter($importer);

    /**
     * Get array of criteria data.
     *
     * @return array
     */
    public function getCriteria();

    /**
     * Set array of criteria data.
     *
     * @param array $data
     * @return ImportInterface
     */
    public function setCriteria(array $criteria);
}
