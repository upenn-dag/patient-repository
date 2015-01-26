<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Prototype\Model;

use Doctrine\Common\Collections\Collection;

/**
 * Prototype subject interface.
 *
 * Implemented by subjects which may be characterized by prototypes.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PrototypeSubjectInterface
{
    /**
     * Get subject prototype.
     *
     * @return PrototypeInterface
     */
    public function getPrototype();

    /**
     * Set subject prototype.
     *
     * @param PrototypeSubjectInterface|null $prototype
     * @return PrototypeSubjectInterface
     */
    public function setPrototype(PrototypeInterface $prototype = null);

    /**
     * Get a description of the subject.
     *
     * This uses the prototype system to get a description for this specific
     * resource based on configuration.
     *
     * @return string
     */
    public function getDescription();
}
