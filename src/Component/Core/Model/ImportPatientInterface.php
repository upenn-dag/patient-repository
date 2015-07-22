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

use Accard\Component\Patient\Model\PatientInterface as BasePatientInterface;
use DAG\Component\Resource\Model\ImportTargetInterface;
use DateTime;

/**
 * Accard import patient interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ImportPatientInterface extends BasePatientInterface, ImportTargetInterface
{
}
