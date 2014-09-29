<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Prototype\Provider;

use Accard\Component\Prototype\Model\PrototypeInterface;
use Accard\Component\Prototype\Exception\PrototypeNotFoundException;

/**
 * Prototype provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PrototypeProviderInterface
{
    /**
     * Get all prototypes.
     *
     * @return PrototypeInterface[]
     */
    public function getAll();

    /**
     * Get model class.
     *
     * @return string
     */
    public function getModelClass();

    /**
     * Get prototype by id.
     *
     * @throws PrototypeNotFoundException If prototype can not be found.
     * @param integer $prototypeId
     * @return PrototypeInterface
     */
    public function getPrototype($prototypeId);

    /**
     * Get prototype by name.
     *
     * @throws PrototypeNotFoundException If prototype can not be found.
     * @param string $prototypeName
     * @return PrototypeInterface
     */
    public function getPrototypeByName($prototypeName);
}
