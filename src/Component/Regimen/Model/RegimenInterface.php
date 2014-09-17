<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Regimen\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Basic regimen interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface RegimenInterface
{
    /**
     * Get regimen id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get parent.
     *
     * @return RegimenInterface
     */
    public function getParent();

    /**
     * Set parent.
     *
     * @param RegimenInterface|null $regimen
     * @return RegimenInterface
     */
    public function setParent(RegimenInterface $regimen = null);

    /**
     * Get children.
     *
     * @return Collection|RegimenInterface[]
     */
    public function getChildren();

    /**
     * Test for presence of a child regimen.
     *
     * @param RegimenInterface $regimen
     * @return RegimenInterface
     */
    public function hasChild(RegimenInterface $regimen);

    /**
     * Add child regimen.
     *
     * @param RegimenInterface $regimen
     * @return RegimenInterface
     */
    public function addChild(RegimenInterface $regimen);

    /**
     * Remove child regimen.
     *
     * @param RegimenInterface $regimen
     * @return RegimenInterface
     */
    public function removeChild(RegimenInterface $regimen);

    /**
     * Test if regimen is a child.
     *
     * @return boolean
     */
    public function isChild();

    /**
     * Test if a regimen is a parent.
     *
     * @return boolean
     */
    public function isParent();
}
