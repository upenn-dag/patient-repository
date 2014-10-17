<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Order entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_ORDERS")
 *
 */
class Order implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_order_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="order_name", type="string")
     *
     * @var string
     */
    protected $orderName;

    /**
     * @ORM\Column(name="order_date", type="datetime")
     *
     * @var DateTime
     */
    protected $orderDate;

    /**
     * @ORM\Column(name="order_start_date", type="datetime")
     *
     * @var DateTime
     */
    protected $orderStartDate;

    /**
     * @ORM\Column(name="order_stop_date", type="datetime")
     *
     * @var DateTime
     */
    protected $orderStopDate;

    /**
     * @ORM\Column(name="specimen", type="string")
     *
     * @var string
     */
    protected $specimen;

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
     * Patient
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Patient", inversedBy="orders")
     * @ORM\JoinColumn(name="fk_patient_id", referencedColumnName="pk_patient_id")
     */
    protected $patient;

    /**
     * Encounter
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Encounter", inversedBy="orders")
     * @ORM\JoinColumn(name="fk_encounter_id", referencedColumnName="pk_encounter_id")
     */
    protected $encounter;

    /**
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\MedicationOrder", mappedBy="order")
     **/
    protected $medicationOrders;

    /**
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\OrderResult", mappedBy="order")
     **/
    protected $orderResults;

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
    public function getOrderName()
    {
        return $this->orderName;
    }

    /**
     * @return Datetime
     */
    public function getOrderDate()
    {
        return $this->orderDate;
    }

    /**
     * @return Datetime
     */
    public function getOrderStartDate()
    {
        return $this->orderStartDate;
    }

    /**
     * @return Datetime
     */
    public function getOrderStopDate()
    {
        return $this->orderStopDate;
    }

    /**
     * @return string
     */
    public function getSpecimen()
    {
        return $this->specimen;
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
     * @return Patient
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * @return Encounter
     */
    public function getEncounter()
    {
        return $this->encounter;
    }

    /**
     * @return MedicationOrder[]
     */
    public function getMedicationOrders()
    {
        return $this->encounter;
    }

    /**
     * @return OrderResult[]
     */
    public function getOrderResults()
    {
        return $this->orderResults;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'patient' => $this->getPatient(),
            'order_name' => $this->getOrderName(),
            'order_date' => $this->getOrderDate(),
            'order_start_date' => $this->getOrderStartDate(),
            'order_stop_date' => $this->getOrderStopDate(),
            'specimen' => $this->getSpecimen(),
            'source_code' => $this->getSourceCode(),
            'source_origin_id' => $this->getSourceOriginId()
        ];
    }
}