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

use Accard\Component\Activity\Model\ObservationInterface as BaseObservationInterface;

/**
 * Accard observation interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ObservationInterface extends BaseObservationInterface, ActivityInterface
{
}
