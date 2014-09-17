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

use Accard\Component\Activity\Model\Conclusion as BaseConclusion;
use DateTime;

/**
 * Accard conclusion model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Conclusion extends BaseConclusion implements ConclusionInterface
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
