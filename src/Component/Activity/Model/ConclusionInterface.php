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

/**
 * Conclusion activity interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ConclusionInterface extends ActivityInterface
{
    /**
     * Get test.
     * 
     * @return TestInterface
     */
    public function getTest();

    /**
     * Set test.
     * 
     * @param TestInterface|null $test
     * @return ConclusionInterface
     */
    public function setTest(TestInterface $test = null);
}
