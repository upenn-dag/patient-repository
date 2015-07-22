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

use Accard\Component\Activity\Model\ActivityInterface as BaseActivityInterface;
use DAG\Component\Resource\Model\ImportTargetInterface;
use DateTime;

/**
 * Accard import activity interface.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
interface ImportActivityInterface extends BaseActivityInterface, ImportTargetInterface
{
}
