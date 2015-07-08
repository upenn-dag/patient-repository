<?php


/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Patient\Test;

use Accard\Component\Patient\Model\PatientCollectingTrait;
use Accard\Component\Patient\Model\PatientCollectingInterface;

/**
 * Patient collection stub.
 *
 * This class is used by the testing framework to ensure the patient collecting
 * trait acts as it should.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientCollectingSubject implements PatientCollectingInterface
{
    use PatientCollectingTrait;
}
