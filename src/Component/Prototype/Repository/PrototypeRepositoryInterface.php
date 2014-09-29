<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Prototype\Repository;

use Accard\Component\Resource\Repository\RepositoryInterface;
use Accard\Component\Prototype\Model\PrototypeInterface;

/**
 * Prototype repository interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PrototypeRepositoryInterface
{
    /**
     * Get all prototypes.
     *
     * @return PrototypeInterface[]
     */
    public function getAll();

    /**
     * Get prototype by id.
     *
     * @param integer $prototypeId
     * @return PrototypeInterface
     */
    public function getPrototype($prototypeId);

    /**
     * Get prototype by name.
     *
     * @param string $prototypeName
     * @return PrototypeInterface
     */
    public function getPrototypeByName($prototypeName);
}
