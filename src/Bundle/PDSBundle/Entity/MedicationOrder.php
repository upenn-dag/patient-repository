<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Medication Order entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_ORDER_MED")
 */
class MedicationOrder implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_order_med_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="medication_name", type="string")
     *
     * @var string
     */
    protected $medicationName;

    /**
     * @ORM\Column(name="dose", type="string")
     *
     * @var string
     */
    protected $dose;

    /**
     * @ORM\Column(name="unit_of_measure", type="string")
     *
     * @var string
     */
    protected $unitOfMeasure;

    /**
     * @ORM\Column(name="frequency_name", type="string")
     *
     * @var string
     */
    protected $frequencyName;

    /**
     * @ORM\Column(name="quantity", type="string")
     *
     * @var string
     */
    protected $quantity;

    /**
     * @ORM\Column(name="refills", type="string")
     *
     * @var string
     */
    protected $refills;

    /**
     * @ORM\Column(name="source_code", type="string")
     *
     * @var string
     */
    protected $sourceCode;

    /**
     * @ORM\Column(name="source_orig_id", type="string")
     *
     * @var string
     */
    protected $sourceOriginId;

    /**
     * @ORM\Column(name="SOURCE_LAST_UPDATE_DATE", type="datetime")
     *
     * @var \DateTime
     */
    protected $lastUpdated;

    /**
     * Orders
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Order", inversedBy="medicationOrders")
     * @ORM\JoinColumn(name="fk_order_id", referencedColumnName="pk_order_id")
     */
    protected $order;

    /**
     * Medication
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Medication", inversedBy="medicationOrders")
     * @ORM\JoinColumn(name="fk_medication_id", referencedColumnName="pk_medication_id")
     */
    protected $medication;

    /**
     * Medication
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Route", inversedBy="medicationOrders")
     * @ORM\JoinColumn(name="fk_route_id", referencedColumnName="pk_route_id")
     */
    protected $routes;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getMedicationName()
    {
        return $this->medicationName;
    }

    /**
     * @return string
     */
    public function getDose()
    {
        return $this->dose;
    }

    /**
     * @return string
     */
    public function getUnitOfMeasure()
    {
        return $this->unitOfMeasure;
    }

    /**
     * @return string
     */
    public function getFrequencyName()
    {
        return $this->frequencyName;
    }

    /**
     * @return string
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getRefills()
    {
        return $this->refills;
    }

    /**
     * @return string
     */
    public function getSourceCode()
    {
        return $this->sourceCode;
    }

    /**
     * @return string
     */
    public function getSourceOriginId()
    {
        return $this->sourceOriginId;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return Medication
     */
    public function getMedication()
    {
        return $this->medication;
    }

    /**
     * @return Route[]
     */
    public function getRoutes()
    {
        return $this->routes;
    }

    /**
     * @return \DateTime
     */
    public function getLastUpdated()
    {
        return $this->lastUpdated;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'routes' => $this->getRoutes(),
            'order' => $this->getOrder(),
            'medication' => $this->getMedication(),
            'medication_name' => $this->getMedicationName(),
            'dose' => $this->getDose(),
            'unit_of_measure' => $this->getUnitOfMeasure(),
            'frequency_name' => $this->getFrequencyName(),
            'quantity' => $this->getQuantity(),
            'refills' => $this->getRefills(),
            'source_code' => $this->getSourceCode(),
            'source_origin_id' => $this->getSourceOriginId()
        ];
    }
}
