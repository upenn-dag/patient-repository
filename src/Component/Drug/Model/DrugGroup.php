<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Drug\Model;

use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Drug group model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DrugGroup implements DrugGroupInterface
{
    /**
     * Drug group id.
     *
     * @var integer
     */
    protected $id;

    /**
     * Drug group name.
     *
     * @var string
     */
    protected $name;

    /**
     * Presentation.
     *
     * @var string
     */
    protected $presentation;

    /**
     * Drugs.
     *
     * @var Collection|DrugInterface[]
     */
    protected $drugs;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->drugs = new ArrayCollection();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * {@inheritdoc}
     */
    public function setPresentation($presentation)
    {
        $this->presentation = $presentation;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getPresentation()
    {
        return $this->presentation;
    }

    /**
     * {@inheritdoc}
     */
    public function getDrugs()
    {
        return $this->drugs;
    }

    /**
     * {@inheritdoc}
     */
    public function hasDrug(DrugInterface $drug)
    {
        return $this->drugs->contains($drug);
    }

    /**
     * {@inheritdoc}
     */
    public function addDrug(DrugInterface $drug)
    {
        if (!$this->hasDrug($drug)) {
            $drug->addGroup($this);
            $this->drugs->add($drug);
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function removeDrug(DrugInterface $drug)
    {
        if ($this->hasDrug($drug)) {
            $this->drugs->removeElement($drug);
            $drug->removeGroup($this);
        }

        return $this;
    }
}
