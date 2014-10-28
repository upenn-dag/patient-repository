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

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Accard activity model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Activity implements ActivityInterface
{
    use \Accard\Component\Prototype\Model\PrototypeSubjectTrait;
    use \Accard\Component\Field\Model\FieldSubjectTrait;

    /**
     * Activity id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Activity date.
     *
     * @var DateTime
     */
    protected $activityDate;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->fields = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getActivityDate()
    {
        return $this->activityDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivityDate(DateTime $activityDate)
    {
        $this->activityDate = $activityDate;

        return $this;
    }

    public function getCanonical()
    {
        $canonical = 'Activity';

        if ($this->activityDate) {
            $canonical .= ' on '.$this->activityDate->format('d/m/Y');
        }

        return $canonical;
    }

    public function __toString()
    {
        return $this->getCanonical();
    }
}
