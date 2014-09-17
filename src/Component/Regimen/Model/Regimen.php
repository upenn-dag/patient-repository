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
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Accard regimen model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Regimen implements RegimenInterface
{
    /**
     * Regimen id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Parent regimen.
     *
     * @var RegimenInterface
     */
    protected $parent;

    /**
     * Child regimens.
     *
     * @var Collection|RegimenInterface[]
     */
    protected $children;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->children = new ArrayCollection;
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
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * {@inheritdoc}
     */
    public function setParent(RegimenInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * {@inheritdoc}
     */
    public function hasChild(RegimenInterface $regimen)
    {
        return $this->children->contains($regimen);
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(RegimenInterface $regimen)
    {
        if (!$this->hasChild($regimen)) {
            $regimen->setParent($this);
            $this->children->add($regimen);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(RegimenInterface $regimen)
    {
        if ($this->hasChild($regimen)) {
            $this->children->removeElement($regimen);
            $regimen->setParent(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isChild()
    {
        return !$this->isParent();
    }

    /**
     * {@inheritdoc}
     */
    public function isParent()
    {
        return null === $this->parent;
    }
}
