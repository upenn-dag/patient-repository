<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Diagnosis Code entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_R_CODES_DIAGNOSIS")
 * @ORM\Entity(readOnly=true, repositoryClass="Accard\Bundle\PDSBundle\Entity\DiagnosisCodeRepository")
 */
class DiagnosisCode implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_dx_code_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="code_standard_name", type="string")
     *
     * @var string
     */
    protected $codeStandardName;

    /**
     * @ORM\Column(name="code", type="string")
     *
     * @var string
     */
    protected $code;

    /**
     * @ORM\Column(name="sub_category", type="string")
     *
     * @var string
     */
    protected $subCategory;

    /**
     * @ORM\Column(name="description", type="string")
     *
     * @var string
     */
    protected $description;

    /**
     * @ORM\Column(name="create_date", type="datetime")
     *
     * @var DateTime
     */
    protected $createDate;

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
     * @ORM\Column(name="active_yn", type="integer")
     *
     * @var integer|null
     */
    protected $activeYN;

    /**
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\Diagnosis", mappedBy="diagnosisCode")
     **/
    protected $diagnoses;

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
    public function getCodeStandardName()
    {
        return $this->codeStandardName;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getSubCategory()
    {
        return $this->subCategory;
    }

    /**
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return DateTime
     */
    public function getCreateDate()
    {
        return $this->createDate;
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

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'code_standard_name' => $this->getCodeStandardName(),
            'code' => $this->getCode(),
            'sub_category' => $this->getSubCategory(),
            'description' => $this->getDescription(),
            'create_date' => $this->getCreateDate(),
            'is_active' => $this->isActive(),
            'source_code' => $this->getSourceCode(),
            'source_origin_id' => $this->getSourceOriginId()
        ];
    }
}
