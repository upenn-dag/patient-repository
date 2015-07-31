<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Order Result entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_ORDER_RESULT")
 * @ORM\Entity(readOnly=true, repositoryClass="Accard\Bundle\PDSBundle\Entity\OrderResultRepository")
 */
class OrderResult implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_order_result_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="specimen", type="string")
     *
     * @var string
     */
    protected $specimen;

    /**
     * @ORM\Column(name="result_date ", type="datetime")
     *
     * @var DateTime
     */
    protected $resultDate;

    /**
     * @ORM\Column(name="create_date", type="datetime")
     *
     * @var DateTime
     */
    protected $createDate;

    /**
     * @ORM\Column(name="result_status", type="string")
     *
     * @var string
     */
    protected $resultStatus;

    /**
     * @ORM\Column(name="result_value", type="text")
     *
     * @var string
     */
    protected $resultValue;

    /**
     * @ORM\Column(name="abnormal", type="text")
     *
     * @var string
     */
    protected $abnormal;

    /**
     * @ORM\Column(name="value_lower_limit", type="text")
     *
     * @var string
     */
    protected $lowerLimitValue;

    /**
     * @ORM\Column(name="value_upper_limit", type="text")
     *
     * @var string
     */
    protected $upperLimitValue;

    /**
     * @ORM\Column(name="unit_of_measure", type="text")
     *
     * @var string
     */
    protected $unitOfMeasure;

    /**
     * @ORM\Column(name="accession", type="text")
     *
     * @var string
     */
    protected $accession;

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
     * @ORM\Column(name="active_yn", type="string")
     *
     * @var string|null
     */
    protected $activeYN;

    /**
     * Order
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Order", inversedBy="orderResults")
     * @ORM\JoinColumn(name="fk_order_id", referencedColumnName="pk_order_id")
     */
    protected $order;

    /**
     * ResultItem
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\ResultItem", inversedBy="orderResults")
     * @ORM\JoinColumn(name="fk_result_item_id", referencedColumnName="pk_result_item_id")
     */
    protected $resultItem;

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
    public function getSpecimen()
    {
        return $this->specimen;
    }

    /**
     * @return DateTime
     */
    public function getResultDate()
    {
        return $this->resultDate;
    }

    /**
     * @return DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
    }

    /**
     * @return string
     */
    public function getResultStatus()
    {
        return $this->resultStatus;
    }

    /**
     * @return string
     */
    public function getResultValue()
    {
        return $this->resultValue;
    }

    /**
     * @return string
     */
    public function getAbnormal()
    {
        return $this->abnormal;
    }

    /**
     * @return string
     */
    public function getLowerLimitValue()
    {
        return $this->lowerLimitValue;
    }

    /**
     * @return string
     */
    public function getUpperLimitValue()
    {
        return $this->upperLimitValue;
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
    public function getAccession()
    {
        return $this->accession;
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
     * @return bool
     */
    public function isActive()
    {
        if ($this->activeYN === null) {
            return false;
        }

        return (bool)$this->activeYN;
    }

    /**
     * @return Order
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return ResultItem
     */
    public function getResultItem()
    {
        return $this->resultItem;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'order' => $this->getOrders(),
            'resultItem' => $this->getResultItems(),
            'specimen' => $this->getSpecimen(),
            'resultDate' => $this->getResultDate(),
            'createDate' => $this->getCreateDate(),
            'resultStatus' => $this->getResultStatus(),
            'resultValue' => $this->getResultValue(),
            'abnormal' => $this->getAbnormal(),
            'lowerLimitValue' => $this->getLowerLimitValue(),
            'upperLimitValue' => $this->getUpperLimitValue(),
            'unitOfMeasure' => $this->getUnitOfMeasure(),
            'accession' => $this->getAccession(),
            'sourceCode' => $this->getSourceCode(),
            'sourceOriginId' => $this->getSourceOriginId(),
            'active' => $this->getActive()
        ];
    }
}
