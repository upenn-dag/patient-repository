<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Sample\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Accard sample model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Sample implements SampleInterface
{
    /**
     * Sample id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Parent sample.
     *
     * @var SampleInterface
     */
    protected $parent;

    /**
     * Amount.
     *
     * @var integer
     */
    protected $amount = 0;

    /**
     * Amount of parent used.
     *
     * @var integer|null
     */
    protected $amountOfParentUsed;

    /**
     * Child samples.
     *
     * @var Collection|SampleInterface[]
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
    public function setParent(SampleInterface $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * {@inheritdoc}
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmountOfParentUsed()
    {
        return $this->amountOfParentUsed;
    }

    /**
     * {@inheritdoc}
     */
    public function setAmountOfParentUsed($amountOfParentUsed = null)
    {
        $this->amountOfParentUsed = $amountOfParentUsed;

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
    public function hasChild(SampleInterface $sample)
    {
        return $this->children->contains($sample);
    }

    /**
     * {@inheritdoc}
     */
    public function addChild(SampleInterface $sample)
    {
        if (!$this->hasChild($sample)) {
            $sample->setParent($this);
            $this->children->add($sample);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeChild(SampleInterface $sample)
    {
        if ($this->hasChild($sample)) {
            $this->children->removeElement($sample);
            $sample->setParent(null);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getAmountRemaining()
    {
        $amount = $this->amount;
        foreach ($this->children as $sample) {
            $amount -= $sample->getAmount();
        }

        return $amount;
    }

    /**
     * {@inheritdoc}
     */
    public function isDerivative()
    {
        return !$this->isSource();
    }

    /**
     * {@inheritdoc}
     */
    public function isSource()
    {
        return null === $this->parent;
    }
}
