<?php

namespace Accard\Bundle\PDSBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PDS Route entity
 *
 * @ORM\Entity(readOnly=true)
 * @ORM\Table(name="PDS_ODS_R_ROUTE")
 *
 * @todo Turn "associated" data into separate entities.
 */
class Route implements \JsonSerializable
{
    /**
     * @ORM\Id
     * @ORM\Column(name="pk_route_id", type="integer")
     *
     * @var integer
     */
    protected $id;

    /**
     * @ORM\Column(name="route_code", type="string")
     *
     * @var string
     */
    protected $routeCode;

    /**
     * @ORM\Column(name="route_description", type="string")
     *
     * @var string
     */
    protected $routeDescription;

    /**
     * @ORM\Column(name="route_type", type="string")
     *
     * @var string
     */
    protected $routeType;

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
     * MedicationOrders
     *
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\Medication", mappedBy="routes")
     */
    protected $medications;

    /**
     * MedicationOrders
     *
     * @ORM\OneToMany(targetEntity="Accard\Bundle\PDSBundle\Entity\MedicationOrder", mappedBy="routes")
     */
    protected $medicationOrders;

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
    public function getRouteCode()
    {
        return $this->routeCode;
    }

    /**
     * @return string
     */
    public function getRouteDescription()
    {
        return $this->routeDescription;
    }

    /**
     * @return string
     */
    public function getRouteType()
    {
        return $this->routeType;
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
            "id" => $this->getId(),
            "route_code" => $this->getRouteCode(),
            "route_description" => $this->getRouteDescription(),
            "route_type" => $this->getRouteType(),
            "source_code" => $this->getSourceCode(),
            "source_origin_id" => $this->getSourceOriginId()
        ];
    }
}
