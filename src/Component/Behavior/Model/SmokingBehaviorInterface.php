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
 * Smoking behavior interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface SmokingBehaviorInterface extends BehaviorInterface
{
    /**
     * Set smoking type.
     *
     * @param string $type
     * @return SmokingBehaviorInterface
     */
    public function setType($type);

    /**
     * Get smoking type.
     *
     * @return string
     */
    public function getType();

    /**
     * Set smoking frequency.
     *
     * @param string $frequency
     * @return SmokingBehaviorInterface
     */
    public function setFrequency($frequency);

    /**
     * Get smoking frequency.
     *
     * @return string
     */
    public function getFrequency();
}
