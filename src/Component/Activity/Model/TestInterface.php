<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Model;

use Doctrine\Common\Collections\Collection as DoctrineCollection;

/**
 * Test activity interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface TestInterface extends ActivityInterface
{
    /**
     * Get conclusions.
     *
     * @return Collection|ConclusionInterface[]
     */
    public function getConclusions();

    /**
     * Test for presence of a conclusion.
     *
     * @param ConclusionInterface $conclusion
     * @return boolean
     */
    public function hasConclusion(ConclusionInterface $conclusion);

    /**
     * Add conclusion.
     *
     * @param ConclusionInterface $conclusion
     * @return TestInterface
     */
    public function addConclusion(ConclusionInterface $conclusion);

    /**
     * Remove conclusion.
     *
     * @param ConclusionInterface $conclusion
     * @return TestInterface
     */
    public function removeConclusion(ConclusionInterface $conclusion);
}
