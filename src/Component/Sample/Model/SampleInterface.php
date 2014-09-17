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

/**
 * Basic sample interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface SampleInterface
{
    /**
     * Get sample id.
     *
     * @return integer
     */
    public function getId();

    /**
     * Get parent.
     *
     * @return SampleInterface
     */
    public function getParent();

    /**
     * Set parent.
     *
     * @param SampleInterface|null $sample
     * @return SampleInterface
     */
    public function setParent(SampleInterface $sample = null);

    /**
     * Get amount.
     *
     * @return integer
     */
    public function getAmount();

    /**
     * Set amount.
     *
     * @param integer $amount
     * @return SampleInterface
     */
    public function setAmount($amount);

    /**
     * Get amount of parent used.
     *
     * @return SampleInterface
     */
    public function getAmountOfParentUsed();

    /**
     * Set amount of parent used.
     *
     * @param integer|null $amountOfParentUsed
     * @return SampleInterface
     */
    public function setAmountOfParentUsed($amountOfParentUsed = null);

    /**
     * Get children.
     *
     * @return Collection|SampleInterface[]
     */
    public function getChildren();

    /**
     * Test for presence of a child sample.
     *
     * @param SampleInterface $sample
     * @return SampleInterface
     */
    public function hasChild(SampleInterface $sample);

    /**
     * Add child sample.
     *
     * @param SampleInterface $sample
     * @return SampleInterface
     */
    public function addChild(SampleInterface $sample);

    /**
     * Remove child sample.
     *
     * @param SampleInterface $sample
     * @return SampleInterface
     */
    public function removeChild(SampleInterface $sample);

    /**
     * Get amount of sample remaining.
     *
     * @return integer
     */
    public function getAmountRemaining();

    /**
     * Test if sample is a derivative.
     *
     * @return boolean
     */
    public function isDerivative();

    /**
     * Test if a sample is a souce.
     *
     * @return boolean
     */
    public function isSource();
}
