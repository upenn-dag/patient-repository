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
 * Conclusion activity model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Conclusion extends Activity implements ConclusionInterface
{
    /**
     * Test.
     * 
     * @var TestInterface
     */

    protected $test;

    /**
     * {@inheritdoc}
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * {@inheritdoc}
     */
    public function setTest(TestInterface $test = null)
    {
        $this->test = $test;

        return $this;
    }
}
