<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Regimen\Model;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Accard\Component\Drug\Model\DrugInterface;
use Accard\Component\Activity\Model\ActivityInterface;

/**
 * Accard regimen model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Regimen implements RegimenInterface
{
    use \DAG\Component\Prototype\Model\PrototypeSubjectTrait;
    use \DAG\Component\Field\Model\FieldSubjectTrait;

    /**
     * Regimen id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Start date.
     *
     * @param DateTime
     */
    protected $startDate;

    /**
     * End date.
     *
     * @param DateTime|null
     */
    protected $endDate;

    /**
     * Drug.
     *
     * @var DrugInterface|null
     */
    protected $drug;

    /**
     * Activities.
     *
     * @var Collection|ActivityInterface[]
     */
    protected $activities;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->fields = new ArrayCollection();
        $this->activities = new ArrayCollection();
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
    public function getStartDate()
    {
        return $this->startDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setStartDate(DateTime $startDate)
    {
        $this->startDate = $startDate;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getEndDate()
    {
        return $this->endDate;
    }

    /**
     * {@inheritdoc}
     */
    public function setEndDate(DateTime $endDate = null)
    {
        $this->endDate = $endDate;

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
        if (null === $this->prototype) {
            return false;
        }

        return $this->prototype->getAllowDrug();
    }

    /**
     * {@inheritdoc}
     */
    public function getActivities()
    {
        return $this->activities;
    }

    /**
     * {@inheritdoc}
     */
    public function hasActivity(ActivityInterface $activity)
    {
        return $this->activities->contains($activity);
    }

    /**
     * {@inheritdoc}
     */
    public function addActivity(ActivityInterface $activity)
    {
        if (!$this->hasActivity($activity)) {
            $activity->setRegimen($this);
            $this->activities->add($activity);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeActivity(ActivityInterface $activity)
    {
        if ($this->hasActivity($activity)) {
            $this->activities->removeElement($activity);
            $activity->setRegimen(null);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return sprintf("Regimen #%d", $this->id);
    }

    /**
     * {@inheritdoc}
     */
    public function isAfterStartDate()
    {
        if (null === $this->endDate) {
            return true;
        }

        return $this->startDate < $this->endDate;
    }
}
