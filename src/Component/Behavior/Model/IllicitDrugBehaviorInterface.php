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
 * Illicit drug behavior interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface IllicitDrugBehaviorInterface extends BehaviorInterface
{
    /**
     * Set type.
     *
     * @param string $type
     * @return IllicitDrugBehaviorInterface
     */
    public function setType($type);

    /**
     * Get type.
     *
     * @return string $type
     */
    public function getType();

    /**
     * Set method.
     *
     * @param string $method
     * @return IllicitDrugBehaviorInterface
     */
    public function setMethod($method);

    /**
     * Get method.
     *
     * @return integer
     */
    public function getMethod();

    /**
     * Set frequency.
     *
     * @param string $frequency
     * @return IllicitDrugBehaviorInterface
     */
    public function setFrequency($frequency);

    /**
     * Get frequency.
     *
     * @return integer
     */
    public function getFrequency();
}
