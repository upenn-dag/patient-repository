<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core\Model;

/**
 * Accard education behavior model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class EducationBehavior extends Behavior implements EducationBehaviorInterface
{
    /**
     * level of education.
     *
     * @var string
     */
    protected $level;

    /**
     * Completed.
     *
     * @var boolean
     */
    protected $completed;

    /**
     * Number of years attended.
     *
     * @var integer
     */
    protected $years;


    /**
     * {@inheritdoc}
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     */
    public function setLevel($level)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getYears()
    {
        return $this->level;
    }

    /**
     * {@inheritdoc}
     */
    public function setYears($years)
    {
        $this->years = $years;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * {@inheritdoc}
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;

        return $this;
    }
}
