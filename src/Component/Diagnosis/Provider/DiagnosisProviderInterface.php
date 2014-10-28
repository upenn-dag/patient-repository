<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Diagnosis\Provider;

use Doctrine\Common\Collections\Collection;
use Accard\Component\Resource\Provider\ProviderInterface;
use Accard\Component\Diagnosis\Model\DiagnosisInterface;

/**
 * Diagnosis provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface DiagnosisProviderInterface extends ProviderInterface
{
    /**
     * Get all diagnoses.
     *
     * @return Collection|DiagnosisInterface[]
     */
    public function getDiagnoses();

    /**
     * Get diangnosis by id.
     *
     * @throws DiagnosisNotFoundException If diagnosis is not found.
     * @param integer $diagnosisId
     * @return DiagnosisInterface
     */
    public function getDiagnosis($diagnosisId);
}
