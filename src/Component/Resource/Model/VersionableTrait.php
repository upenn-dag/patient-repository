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
 * Versionable trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait VersionableTrait
{
    /**
     * Current version.
     *
     * @var integer
     */
    protected $currentVersion = 0;


    /**
     * {@inheritdoc}
     */
    public function getCurrentVersion()
    {
        return $this->currentVersion;
    }

    /**
     * {@inheritdoc}
     */
    public function setCurrentVersion($currentVersion)
    {
        $this->currentVersion = $currentVersion;

        return $this;
    }
}
