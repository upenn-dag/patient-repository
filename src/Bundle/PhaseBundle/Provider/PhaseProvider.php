<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PhaseBundle\Provider;

use Accard\Component\Phase\Provider\PhaseProviderInterface;
use Accard\Component\Phase\Exception\PhaseNotFoundException;
use Accard\Component\Phase\Model\PhaseInterface;
use Accard\Component\Phase\Model\PhaseInstanceInterface;
use Accard\Component\Phase\Repository\PhaseRepositoryInterface;
use Accard\Component\Phase\Repository\PhaseInstanceRepositoryInterface;

/**
 * Phase provider.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhaseProvider implements PhaseProviderInterface
{
    /**
     * Phase repository.
     *
     * @var PhaseRepositoryInterface
     */
    protected $phaseRepository;

    /**
     * Phase instance repository.
     *
     * @var PhaseInstanceRepository
     */
    protected $phaseInstanceRepository;


    /**
     * Constructor.
     *
     * @param PhaseRepositoryInterface $phaseRepository
     * @param PhaseIntanceRepositoryInterface $phaseInstanceRepository
     */
    public function __construct(PhaseRepositoryInterface $phaseRepository,
                                PhaseInstanceRepositoryInterface $phaseInstanceRepository)
    {
        $this->phaseRepository = $phaseRepository;
        $this->phaseInstanceRepository = $phaseInstanceRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhaseRepository()
    {
        return $this->phaseRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhaseInstanceRepository()
    {
        return $this->phaseInstanceRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhases()
    {
        return $this->phaseRepository->findAll();
    }

    /**
     * {@inheritdoc}
     */
    public function getPhase($id)
    {
        if (!$phase = $this->phaseRepository->find($id)) {
            throw new PhaseNotFoundException($id);
        }

        return $phase;
    }

    /**
     * {@inheritdoc}
     */
    public function getPhaseByName($name)
    {
        if (!$phase = $this->phaseRepository->findOneByLabel($label)) {
            throw new PhaseNotFoundException($label);
        }

        return $phase;
    }
}
