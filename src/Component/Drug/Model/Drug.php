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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Drug model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Drug implements DrugInterface
{
    /**
     * Drug id.
     * 
     * @var integer
     */
    protected $id;

    /**
     * Drug name.
     * 
     * @var string
     */
    protected $name;

    /**
     * Presentation.
     * 
     * @var string
     */
    protected $presentation;

    /**
     * Generic drug (parent).
     * 
     * @var DrugInterface|null
     */
    protected $generic;

    /**
     * Brand drugs (children).
     * 
     * @var Collection|DrugInterface[]
     */
    protected $brands;

    /**
     * Drug groups.
     * 
     * @var Collection|DrugGroupInterface[]
     */
    protected $groups;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->groups = new ArrayCollection();
        $this->brands = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setPresentation($presentation = null)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * {@inheritdoc}
     */
    public function getGroups()
    {
        return $this->groups;
    }

    /**
     * {@inheritdoc}
     */
    public function hasGroup(DrugGroupInterface $group)
    {
        return $this->groups->contains($group);
    }

    /**
     * {@inheritdoc}
     */
    public function addGroup(DrugGroupInterface $group)
    {
        if (!$this->hasGroup($group)) {
            $this->groups->add($group);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeGroup(DrugGroupInterface $group)
    {
        if ($this->hasGroup($group)) {
            $this->groups->removeElement($group);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isGeneric()
    {
        return $this->generic instanceof DrugInterface;
    }

    /**
     * {@inheritdoc}
     */
    public function setGeneric(DrugInterface $generic = null)
    {
        $this->generic = $generic;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getGeneric()
    {
        return $this->generic;
    }

    /**
     * {@inheritdoc}
     */
    public function getBrands()
    {
        return $this->brands;
    }

    /**
     * {@inheritdoc}
     */
    public function hasBrand(DrugInterface $brand = null)
    {
        if (null === $brand) {
            return (boolean) $this->brands->count();
        }

        return $this->brands->contains($brand);
    }

    /**
     * {@inheritdoc}
     */
    public function addBrand(DrugInterface $brand)
    {
        if (!$this->hasBrand($brand)) {
            $brand->setGeneric($this);
            $this->brands->add($brand);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeBrand(DrugInterface $brand)
    {
        if ($this->hasBrand($brand)) {
            $this->brands->removeElement($brand);
            $brand->setGeneric(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        $str = sprintf('Drug #%d ', $this->id);

        return $str.($this->isGeneric() ? '(generic)' : '(brand)');
    }
}
