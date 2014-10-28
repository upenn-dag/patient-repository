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

/**
 * Accard regimen model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Regimen implements RegimenInterface
{
    use \Accard\Component\Prototype\Model\PrototypeSubjectTrait;
    use \Accard\Component\Field\Model\FieldSubjectTrait;

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
}
