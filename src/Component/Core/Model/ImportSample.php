<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core\Model;

use Accard\Component\Sample\Model\Sample as BaseSample;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use DateTime;

/**
 * Accard import sample model.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class ImportSample extends BaseSample implements ImportSampleInterface
{
    // Traits
    use \Accard\Component\Resource\Model\ImportTargetTrait;

    /**
     * Patient.
     *
     * @var PatientInterface
     */
    protected $patient;

    /**
     * {@inheritdoc}
     */
    public function getPatient()
    {
        return $this->patient;
    }

    /**
     * {@inheritdoc}
     */
    public function setPatient(PatientInterface $patient = null)
    {
        $this->patient = $patient;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hasPatient()
    {
        return $this->patient instanceof PatientInterface;
    }
}
