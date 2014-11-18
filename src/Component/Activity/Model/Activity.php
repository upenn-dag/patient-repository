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
use Accard\Component\Drug\Model\DrugInterface;

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
     * Drug.
     *
     * @var DrugInterface|null
     */
    protected $drug;


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

    /**
     * {@inheritdoc}
     */
    public function getDrug()
    {
        return $this->drug;
    }

    /**
     * {@inheritdoc}
     */
    public function setDrug(DrugInterface $drug = null)
    {
        $this->drug = $drug;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function isDruggable()
    {
        return $this->prototype->allowDrug();
    }

    public function getCanonical()
    {
        $canonical = sprintf('Activity #%d', $this->id);

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
