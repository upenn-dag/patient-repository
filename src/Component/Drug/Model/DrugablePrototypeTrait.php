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

/**
 * Drugable prototype trait.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
trait DrugablePrototypeTrait
{
    /**
     * Allow drug?
     *
     * @var boolean
     */
    protected $allowDrug = false;

    /**
     * Drug group.
     *
     * @var DrugGroupInterface
     */
    protected $drugGroup;


    /**
     * {@inheritdoc}
     */
    public function getAllowDrug()
    {
        return $this->allowDrug;
    }

    /**
     * {@inheritdoc}
     */
    public function setAllowDrug($allowDrug)
    {
        $this->allowDrug = $allowDrug;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getDrugGroup()
    {
        return $this->drugGroup;
    }

    /**
     * {@inheritdoc}
     */
    public function setDrugGroup(DrugGroupInterface $drugGroup = null)
    {
        $this->drugGroup = $drugGroup;

        return $this;
    }
}
