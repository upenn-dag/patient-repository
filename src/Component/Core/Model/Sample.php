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

/**
 * Accard sample model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Sample extends BaseSample implements SampleInterface
{
    use \Accard\Component\Patient\Model\PatientCollectingTrait;
}
