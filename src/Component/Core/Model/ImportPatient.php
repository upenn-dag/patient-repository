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

use Accard\Component\Patient\Model\Patient as BasePatient;
use DateTime;

/**
 * Accard import patient model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportPatient extends BasePatient implements ImportPatientInterface
{
    // Traits
    use \Accard\Component\Resource\Model\ImportTargetTrait;
}
