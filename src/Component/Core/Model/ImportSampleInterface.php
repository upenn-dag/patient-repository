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

use Accard\Component\Sample\Model\SampleInterface as BaseSampleInterface;
use Accard\Component\Resource\Model\ImportTargetInterface;
use DateTime;

/**
 * Accard import patient interface.
 *
 * @author Dylan Pierce <piercedy@med.upenn.edu>
 */
interface ImportSampleInterface extends BaseSampleInterface, ImportTargetInterface
{
}
