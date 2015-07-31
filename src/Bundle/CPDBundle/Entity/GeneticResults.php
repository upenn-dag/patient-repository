<?php

namespace Accard\Bundle\CPDBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CPD Gene Results entity
 *
 * @autho Dylan Pierce <piercedy@upenn.edu>
 */
class GeneticResults implements \JsonSerializable
{
    /**
     * CPD result id
     */
    protected $id;

    /**
     * Patient MRN
     */
    protected $patientMRN;

    /**
     * Date tested
     */
    protected $dateTested;

    /**
     * Variant Detected
     */
    protected $variantDetected;

    /**
     * Variant Categorization
     */
    protected $variantCategorization;

    /**
     * CDNA Change
     */
    protected $cdnaChange;

    /**
     * Protein change
     */
    protected $proteinChange;

    /**
     * Mutation type cdna
     */
    protected $mutationTypeCdna;

    /**
     * Mutation type protein
     */
    protected $mutationTypeProtein;

    /**
     * Variant alias
     */
    protected $variantAlias;

    /**
     * get Id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get patient mrn
     */
    public function getPatientMRN()
    {
        return $this->patientMRN;
    }

    /**
     * Get date tested
     */
    public function getDateTested()
    {
        return $this->dateTested;
    }

    /**
     * Get variant detected
     */
    public function getVariantDetected()
    {
        return $this->variantDetected;
    }

    /**
     * Get variant Categorization
     */
    public function getVariantCategorization()
    {
        return $this->variantCategorization;
    }

    /**
     * Get cdna change
     */
    public function getCdnaChange()
    {
        return $this->cdnaChange;
    }

    /**
     * Get protein change
     */
    public function getProteinChange()
    {
        return $this->proteinChange;
    }

    /**
     * Get mutation type cdna
     */
    public function getMutationTypeCdna()
    {
        return $this->mutationTypeCdna;
    }

    /**
     * Get variant alias
     */
    public function getVariantAlias()
    {
        return $this->variantAlias;
    }
}
