<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Encounter entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_ENCOUNTER")
 */
class Encounter implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_encounter_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * Patient
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Patient", inversedBy="encounters")
     * @ORM\JoinColumn(name="fk_patient_id", referencedColumnName="pk_patient_id")
     */
    protected $patient;

    /**
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\Diagnosis", mappedBy="encounter")
     **/
    protected $diagnoses;

    /**
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\Order", mappedBy="encounter")
     **/
    protected $orders;

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
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return Patient
     */
    public function getPatient()
    {
        return $this->patient;
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
     * @return Diagnosis[]
     */
    public function getDiagnoses()
    {
        return $this->diagnoses;
    }

    /**
     * @return Order[]
     */
    public function getOrders()
    {
        return $this->orders;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'patient' => $this->getPatient(),
            'source_code' => $this->getSourceCode(),
            'source_origin_id' => $this->getSourceOriginId()
        ];
    }
}
