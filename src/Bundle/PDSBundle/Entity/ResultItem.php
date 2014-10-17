<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Result Item entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_R_RESULT_ITEM")
 */
class ResultItem implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_result_item_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="result_item_code", type="string")
     *
     * @var string|null
     */
    protected $itemCode;

    /**
     * @ORM\Column(name="result_item_description", type="string")
     *
     * @var string|null
     */
    protected $itemDescription;

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
     * @ORM\Column(name="loinc_code", type="string")
     *
     * @var string|null
     */
    protected $loincCode;

    /**
     * @ORM\Column(name="active_yn", type="integer")
     *
     * @var integer|null
     */
    protected $activeYN;

    /**
     * OrderResult
     *
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\OrderResult", mappedBy="resultItem")
     */
    protected $orderResults;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getItemCode()
    {
        return $this->itemCode;
    }

    /**
     * @return string|null
     */
    public function getItemDescription()
    {
        return $this->itemDescription;
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
     * @return string
     */
    public function getLoincCode()
    {
        return $this->loincCode;
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
     * @return OrderResult
     */
    public function getOrderResults()
    {
        return $this->orderResults;
    }

    public function jsonSerialize()
    {
        return [
            "id" => $this->getId(),
            "item_code" => $this->getItemCode(),
            "item_description" => $this->getItemDescription(),
            "source_code" => $this->getSourceCode(),
            "source_origin_id" => $this->getSourceOriginId(),
            "loinc_code" => $this->getLoincCode(),
            "active" => $this->isActive()
        ];
    }
}
