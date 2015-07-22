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

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Accard behavior model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Behavior implements BehaviorInterface
{
    use \DAG\Component\Prototype\Model\PrototypeSubjectTrait;
    use \DAG\Component\Field\Model\FieldSubjectTrait;

    /**
     * Behavior id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Start date.
     *
     * @var DateTime
     */
    protected $startDate;

    /**
     * End date.
     *
     * @var DateTime
     */
    protected $endDate;


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
    public function isAfterStartDate()
    {

        if (null === $this->endDate) {
            return true;
        }

        return $this->startDate < $this->endDate;

    }
}
