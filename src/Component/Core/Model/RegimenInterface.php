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

use Accard\Component\Regimen\Model\RegimenInterface as BaseRegimenInterface;
use Accard\Component\Resource\Model\BlameableInterface;
use Accard\Component\Resource\Model\VersionableInterface;
use Accard\Component\Resource\Model\TimestampableInterface;

/**
 * Accard activity interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface RegimenInterface extends BaseRegimenInterface,
                                   TimestampableInterface,
                                   BlameableInterface,
                                   VersionableInterface
{
    /**
     * Get diagnosis.
     *
     * @return DiagnosisInterface
     */
    public function getDiagnosis();

    /**
     * Set diagnosis.
     *
     * @param DiagnosisInterface $diagnosis
     * @return RegimenInterface
     */
    public function setDiagnosis(DiagnosisInterface $diagnosis = null);
}
