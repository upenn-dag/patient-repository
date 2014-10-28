<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Repository;

use Doctrine\Common\Collections\Collection;
use Accard\Component\Diagnosis\Model\DiagnosisInterface;
use Accard\Component\Diagnosis\Model\CodeInterface;
use Accard\Component\Resource\Repository\RepositoryInterface;

/**
 * Diagnosis repository interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DiagnosisRepositoryInterface extends RepositoryInterface
{
    /**
     * Get all ongoing diagnoses.
     *
     * @param array $criteria
     * @param array $sorting
     * @return Collection|DiagnosisInterface[]
     */
    public function getOngoingDiagnoses(array $criteria = array(), array $sorting = array());
}
