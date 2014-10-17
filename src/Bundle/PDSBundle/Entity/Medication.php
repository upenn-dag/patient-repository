<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Medication entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_R_MEDICATION")
 * @ORM\Entity(readOnly=true, repositoryClass="Accard\Bundle\PDSBundle\Entity\MedicationRepository")
 */
class Medication implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_medication_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="full_name", type="string")
     *
     * @var string
     */
    protected $fullName;

    /**
     * @ORM\Column(name="simple_generic_name", type="string")
     *
     * @var string
     */
    protected $simpleGenericName;

    /**
     * @ORM\Column(name="generic_name", type="string")
     *
     * @var string
     */
    protected $genericName;

    /**
     * @ORM\Column(name="therapeutic_class", type="string")
     *
     * @var string
     */
    protected $therapeuticClass;

    /**
     * @ORM\Column(name="pharmacy_class", type="string")
     *
     * @var string
     */
    protected $pharmacyClass;

    /**
     * @ORM\Column(name="pharmacy_subclass", type="string")
     *
     * @var string
     */
    protected $pharmacySubclass;

    /**
     * @ORM\Column(name="dea_class", type="string")
     *
     * @var string
     */
    protected $deaClass;

    /**
     * @ORM\Column(name="amount", type="string")
     *
     * @var string
     */
    protected $amount;

    /**
     * @ORM\Column(name="form", type="string")
     *
     * @var string
     */
    protected $form;

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
     * @ORM\Column(name="controlled_med_yn", type="integer")
     *
     * @var integer
     */
    protected $controlledMedicationYN;

    /**
     * MedicationOrders
     *
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\MedicationOrder", mappedBy="medication")
     */
    protected $medicationOrders;

    /**
     * Routes
     *
     * @ORM\ManyToOne(targetEntity="Accard\Bundle\PDSBundle\Entity\Route", inversedBy="medications")
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
     * @return Route[]
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * @return string
     */
    public function getFullName() {
        return $this->fullName;
    }

    /**
     * @return string
     */
    public function getSimpleGenericName() {
        return $this->simpleGenericName;
    }

    /**
     * @return string
     */
    public function getGenericName() {
        return $this->genericName;
    }

    /**
     * @return string
     */
    public function getTherapeuticClass() {
        return $this->therapeuticClass;
    }

    /**
     * @return string
     */
    public function getPharmacyClass() {
        return $this->pharmacyClass;
    }

    /**
     * @return string
     */
    public function getPharmacySubclass() {
        return $this->pharmacySubclass;
    }

    /**
     * @return string
     */
    public function getDeaClass() {
        return $this->deaClass;
    }

    /**
     * @return string
     */
    public function getAmount() {
        return $this->amount;
    }

    /**
     * @return string
     */
    public function getForm() {
        return $this->form;
    }

    /**
     * @return bool
     */
    public function isControlledMedication() {
        if ($this->controlledMedicationYN === null) {
            return false;
        }
        return (bool) $this->controlledMedicationYN;
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

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'route' => $this->getRoutes(),
            'full_name' => $this->getFullName(),
            'generic_name' => $this->getGenericName(),
            'therapeutic_class' => $this->getTherapeuticClass(),
            'pharmacy_class' => $this->getPharmacyClass(),
            'pharmacy_cubclass' => $this->getPharmacySubclass(),
            'dea_class' => $this->getDeaClass(),
            'amount' => $this->getAmount(),
            'form' => $this->getForm(),
            'is_controlled_medication' => $this->getisControlledMedication(),
            'source_ode' => $this->getSourceCode(),
            'source_origin_id' => $this->getSourceOriginId()
        ];
    }
}
