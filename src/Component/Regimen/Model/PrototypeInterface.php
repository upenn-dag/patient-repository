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

use Accard\Component\Prototype\Model\PrototypeInterface as BasePrototypeInterface;

/**
 * Regimen prototype interface
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PrototypeInterface extends BasePrototypeInterface
{
    /**
     * Get allow drug.
     *
     * @return boolean
     */
    public function getAllowDrug();

    /**
     * Set allow drug.
     *
     * @param boolean $allowDrug
     * @return PrototypeInterface
     */
    public function setAllowDrug($allowDrug);
}
