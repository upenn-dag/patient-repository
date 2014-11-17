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
use Accard\Component\Diagnosis\Exception\DrugNotFoundException;
use Accard\Component\Diagnosis\Model\DrugInterface;

/**
 * Drug provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DrugProviderInterface extends ProviderInterface
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
     * @return Collection|DrugInterface[]
     */
    public function getAllDrugs();

    /**
     * Get drug.
     *
     * @throws DrugNotFoundException If drug can not be located.
     * @param integer $drugId
     * @return DrugInterface
     */
    public function getDrug($drugId);

    /**
     * Get drug by name.
     *
     * @throws DrugNotFoundException If drug can not be located.
     * @param string $drugString
     * @return DrugInterface
     */
    public function getDrugByName($drugName);
}
