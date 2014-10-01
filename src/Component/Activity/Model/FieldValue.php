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

use Accard\Component\Field\Model\FieldValue as BaseFieldValue;

/**
 * Accard activity field value model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValue extends BaseFieldValue implements FieldValueInterface
{
    /**
     * Activity.
     *
     * @var ActivityInterface|null
     */
    protected $activity;


    /**
     * {@inheritdoc}
     */
    public function getActivity()
    {
        return $this->activity;
    }

    /**
     * {@inheritdoc}
     */
    public function setActivity(ActivityInterface $activity = null)
    {
        $this->activity = $activity;

        return $this;
    }
}
