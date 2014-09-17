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

use Accard\Component\Activity\Model\Observation as BaseObservation;
use DateTime;

/**
 * Accard observation model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Observation extends BaseObservation implements ObservationInterface
{
    // Traits
    use ActivityTrait;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->createdAt = new DateTime();
    }
}
