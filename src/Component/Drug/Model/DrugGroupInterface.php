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

use Doctrine\Common\Collections\Collection;
use Accard\Component\Resource\Model\ResourceInterface;

/**
 * Drug group model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DrugGroupInterface extends ResourceInterface
{
    /**
     * Get drug group id.
     * 
     * @var integer
     */
    public function getId();

    /**
     * Set name.
     *
     * @param string $name
     * @return DrugGroupInterface
     */
    public function setName($name);

    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set presentation.
     *
     * @param string $presentation
     * @return DrugGroupInterface
     */
    public function setPresentation($presentation);

    /**
     * Get presentation.
     *
     * @return string
     */
    public function getPresentation();

    /**
     * Get drugs.
     *
     * @return Collection|DrugInterface[]
     */
    public function getDrugs();

    /**
     * Test if drug is present.
     *
     * @param DrugInterface $drug
     * @return boolean
     */
    public function hasDrug(DrugInterface $drug);

    /**
     * Add drug.
     *
     * @param DrugInterface $drug
     * @return DrugGroupInterface
     */
    public function addDrug(DrugInterface $drug);

    /**
     * Remove drug.
     *
     * @param DrugInterface $drug
     * @return DrugGroupInterface
     */
    public function removeDrug(DrugInterface $drug);
}
