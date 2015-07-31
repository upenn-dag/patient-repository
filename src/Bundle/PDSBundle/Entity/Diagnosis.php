<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Diagnosis entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_DIAGNOSIS")
 */
class Diagnosis implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_dx_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="coding_date", type="datetime")
     *
     * @var DateTime
     */
    protected $codingDate;

    /**
     * @ORM\Column(name="active_yn", type="integer")
     *
     * @var integer|null
     */
    protected $activeYN;

    /**
     * @ORM\Column(name="primary_yn", type="integer")
     *
     * @var integer|null
     */
    protected $primaryYN;

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
     * DiagnosisCode
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\DiagnosisCode", inversedBy="diagnoses")
     * @ORM\JoinColumn(name="fk_dx_code_id", referencedColumnName="pk_dx_code_id")
     *
     * @var DiagnosisCode
     */
    protected $diagnosisCode;

    /**
     * Encounter
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Encounter")
     * @ORM\JoinColumn(name="fk_encounter_id", referencedColumnName="pk_encounter_id")
     *
     * @var Encounter
     */
    protected $encounter;

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return DateTime
     */
    public function getCodingDate()
    {
        return $this->codingDate;
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
     * @return bool
     */
    public function isPrimary()
    {
        if ($this->primaryYN === null) {
            return false;
        }

        return (bool)$this->primaryYN;
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
     * @return DiagnosisCode
     */
    public function getDiagnosisCode()
    {
        return $this->diagnosisCode;
    }

    /**
     * @return Encounter[]
     */
    public function getEncounters()
    {
        return $this->encounters;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'coding_date' => $this->getCodingDate(),
            'source_code' => $this->getSourceCode(),
            'is_active' => $this->isActive(),
            'is_primary' => $this->isPrimary(),
            'source_origin_id' => $this->getSourceOriginId()
        ];
    }
}
