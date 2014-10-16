<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Phase\Provider;

use Accard\Component\Phase\Model\PhaseInterface;
use Accard\Component\Phase\Model\PhaseInstanceInterface;
use Accard\Component\Phase\Repository\PhaseRepositoryInterface;
use Accard\Component\Phase\Repository\PhaseInstanceRepositoryInterface;

/**
 * Phase provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface PhaseProviderInterface
{
    /**
     * Get phase repository.
     *
     * @return PhaseRepositoryInterface
     */
    public function getPhaseRepository();

    /**
     * Get phase instance repository.
     *
     * @return PhaseInstanceRepositoryInterface
     */
    public function getPhaseInstanceRepository();

    /**
     * Get all phases.
     *
     * @return PhaseInterface[]
     */
    public function getPhases();

    /**
     * Get phase by id.
     *
     * @param integer $id
     * @return PhaseInterface
     */
    public function getPhase($id);

    /**
     * Get phase by name.
     *
     * @param string $name
     * @return PhaseInterface
     */
    public function getPhaseByName($name);
}
