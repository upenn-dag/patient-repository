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
 * Drug model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DrugInterface extends ResourceInterface
{
    /**
     * Get drug id.
     *
     * @var integer
     */
    public function getId();

    /**
     * Set name.
     *
     * @param string $name
     * @return DrugInterface
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
     * @return DrugInterface
     */
    public function setPresentation($presentation = null);

    /**
     * Get presentation.
     *
     * @return string
     */
    public function getPresentation();

    /**
     * Get groups.
     *
     * @return Collection|DrugGroupInterface[]
     */
    public function getGroups();

    /**
     * Test for groups presence.
     *
     * @param DrugGroupInterface $group
     * @return CodeInterface
     */
    public function hasGroup(DrugGroupInterface $group);

    /**
     * Add group.
     *
     * @param DrugGroupInterface $group
     * @return CodeInterface
     */
    public function addGroup(DrugGroupInterface $group);

    /**
     * Remove group.
     *
     * @param DrugGroupInterface $group
     * @return CodeInterface
     */
    public function removeGroup(DrugGroupInterface $group);

    /**
     * Test if drug is generic.
     *
     * @return boolean
     */
    public function isGeneric();

    /**
     * Set generic.
     *
     * @param DrugInterface|null $generic
     * @return DrugInterface
     */
    public function setGeneric(DrugInterface $generic = null);

    /**
     * Get generic.
     *
     * @return DrugInterface|null
     */
    public function getGeneric();

    /**
     * Get brands.
     *
     * @return Collection|DrugInterface[]
     */
    public function getBrands();

    /**
     * Test for presence of brand or brands.
     *
     * @param DrugInterface|null $brand
     * @return boolean
     */
    public function hasBrand(DrugInterface $brand = null);

    /**
     * Add a brand.
     *
     * @param DrugInterface $brand
     * @return DrugInterface
     */
    public function addBrand(DrugInterface $brand);

    /**
     * Remove a brand.
     *
     * @param DrugInterface $brand
     * @return DrugInterface
     */
    public function removeBrand(DrugInterface $brand);
}
