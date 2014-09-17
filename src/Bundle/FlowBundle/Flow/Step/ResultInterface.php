<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow\Step;

/**
 * Step result interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ResultInterface
{
    const COMPLETE = true;
    const INCOMPLETE = false;

    const SKIP = true;
    const SHOW = false;

    const NEXT = 'next';
    const LAST = 'last';
    const GO = 'go';
    const STAY = 'stay';

    /**
     * Return the result data.
     *
     * @return mixed
     */
    public function getResult();
}
