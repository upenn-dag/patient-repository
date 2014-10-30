<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Doctrine\ORM;

use Accard\Bundle\PhaseBundle\Doctrine\ORM\AbstractPhaseInstanceRepository;

/**
 * Patient phase instance repository.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientPhaseInstanceRepository extends AbstractPhaseInstanceRepository
{
    /**
     * {@inheritdoc}
     */
    public function getAlias()
    {
        return 'patient_phase_instance';
    }
}
