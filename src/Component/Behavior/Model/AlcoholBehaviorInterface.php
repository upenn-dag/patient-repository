<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Behavior\Model;

/**
 * Alcohol behavior interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface AlcoholBehaviorInterface extends BehaviorInterface
{
    /**
     * Set frequency.
     *
     * @param integer $frequency
     * @return AlcoholBehaviorInterface
     */
    public function setFrequency($cfrequency);

    /**
     * Get frequency.
     *
     * @return integer
     */
    public function getFrequency();
}
