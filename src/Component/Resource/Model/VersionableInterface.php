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
 * Version interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface VersionableInterface
{
    /**
     * Get version.
     *
     * @return integer
     */
    public function getCurrentVersion();

    /**
     * Set version.
     *
     * @param integer $creationDate
     */
    public function setCurrentVersion($currentVersion);
}
