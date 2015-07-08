<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Resource\Test\Stub;

use Accard\Component\Resource\Model\ResourceInterface;

/**
 * Stub resource.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Resource implements ResourceInterface
{
    /**
     * @var mixed
     */
    private $test;

    /**
     * Get test property.
     *
     * @return mixed
     */
    public function getTest()
    {
        return $this->test;
    }

    /**
     * Set test property.
     *
     * @return self
     */
    public function setTest($test)
    {
        $this->test = $test;

        return $this;
    }
}
