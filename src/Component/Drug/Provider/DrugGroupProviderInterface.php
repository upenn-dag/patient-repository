<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Drug\Provider;

use Doctrine\Common\Collections\Collection;
use Accard\Component\Resource\Provider\ProviderInterface;
use Accard\Component\Diagnosis\Exception\DrugGroupNotFoundException;
use Accard\Component\Diagnosis\Model\DrugGroupInterface;

/**
 * DrugGroup provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DrugGroupProviderInterface extends ProviderInterface
{
    /**
     * Get model class FQCN.
     *
     * @return string
     */
    public function getModelClass();

    /**
     * Get all drugs.
     *
     * @return Collection|DrugGroupInterface[]
     */
    public function getAllDrugGroups();

    /**
     * Get drug.
     *
     * @throws DrugGroupNotFoundException If drug can not be located.
     * @param integer $drugGroupId
     * @return DrugGroupInterface
     */
    public function getDrugGroup($drugGroupId);

    /**
     * Get drug by name.
     *
     * @throws DrugGroupNotFoundException If drug can not be located.
     * @param string $drugGroupString
     * @return DrugGroupInterface
     */
    public function getDrugGroupByName($drugGroupName);
}
