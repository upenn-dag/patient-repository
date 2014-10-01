<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Activity\Model;

use Accard\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;

/**
 * Activity activity field value model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldValueInterface extends BaseFieldValueInterface
{
    /**
     * Get activity.
     *
     * @return ActivityInterface|null
     */
    public function getActivity();

    /**
     * Set activity.
     *
     * @param ActivityInterface|null $activity
     * @return FieldValueInterface
     */
    public function setActivity(ActivityInterface $activity = null);
}
