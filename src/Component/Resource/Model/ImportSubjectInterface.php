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

use Accard\Component\Resource\Exception\ImportTargetAlreadySetException;

/**
 * Import subject interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ImportSubjectInterface
{
    /**
     * Set import target.
     *
     * Setting the import target must also set the target's set the target's
     * import status to indicate it's been imported and linked.
     *
     * @throws ImportTargetAlreadySetException If target is already set
     * @param ImportTargetInterface|null $target
     * @return ImportSubjectInterface
     */
    public function setImportTarget(ImportTargetInterface $target = null);

    /**
     * Get import target.
     *
     * @return ImportTargetInterface|null
     */
    public function getImportTarget();

    /**
     * Test for import target presence.
     *
     * @return boolean
     */
    public function hasImportTarget();
}
