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
 * Basic education behavior interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface EducationBehaviorInterface extends BehaviorInterface
{
    /**
     * Get level.
     *
     * @return string
     */
    public function getLevel();

    /**
    * Set level.
    *
    * @param string $level
    * @return EducationBehaviorInterface
    */
    public function setLevel($level);

    /**
     * Get years.
     *
     * @return string
     */
    public function getYears();

    /**
    * Set years.
    *
    * @param integer $years
    * @return EducationBehaviorInterface
    */
    public function setYears($years);

    /**
     * Get completed.
     *
     * @return boolean
     */
    public function getCompleted();

    /**
    * Set completed.
    *
    * @param string $completed
    * @return EducationBehaviorInterface
    */
    public function setCompleted($completed);
}
