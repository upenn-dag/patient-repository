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

use Accard\Component\Activity\Model\Decision as BaseDecision;
use DateTime;

/**
 * Accard decision model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Decision extends BaseDecision implements DecisionInterface
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
