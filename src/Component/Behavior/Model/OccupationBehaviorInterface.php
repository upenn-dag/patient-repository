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
 * Occupation behavior interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface OccupationBehaviorInterface extends BehaviorInterface
{
    /**
     * Set industry.
     *
     * @param string $industry
     * @return OccupationBehaviorInterface
     */
    public function setIndustry($industry);

    /**
     * Get industry.
     *
     * @return string
     */
    public function getIndustry();

    /**
     * Set hours (weekly).
     *
     * @param string $hours
     * @return OccupationBehaviorInterface
     */
    public function setHours($hours);

    /**
     * Get hours (weekly).
     *
     * @return string
     */
    public function getHours();
}
