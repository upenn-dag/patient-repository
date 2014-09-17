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

use Accard\Component\Regimen\Model\Regimen as BaseRegimen;
use DateTime;

/**
 * Accard regimen model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Regimen extends BaseRegimen implements RegimenInterface
{
    // Traits
    use \Accard\Component\Resource\Model\BlameableTrait;
    use \Accard\Component\Resource\Model\TimestampableTrait;
    use \Accard\Component\Resource\Model\VersionableTrait;

    /**
     * Diagnosis.
     *
     * @var DiagnosisInterface
     */
    protected $diagnosis;


    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    /**
     * {@inheritdoc}
     */
    public function getDiagnosis()
    {
        return $this->diagnosis;
    }

    /**
     * {@inheritdoc}
     */
    public function setDiagnosis(DiagnosisInterface $diagnosis = null)
    {
        $this->diagnosis = $diagnosis;

        return $this;
    }
}
