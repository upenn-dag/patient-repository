<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Drug\Model;

/**
 * Drugable prototype interface.
 *
 * Included in prototypes that indicate the collection of a drug.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DrugablePrototypeInterface
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

    /**
     * Get drug group.
     *
     * @return DrugGroupInterface
     */
    public function getDrugGroup();

    /**
     * Set drug group.
     *
     * @param DrugGroupInterface|null $drugGroup
     * @return PrototypeInterface
     */
    public function setDrugGroup(DrugGroupInterface $drugGroup = null);
}
