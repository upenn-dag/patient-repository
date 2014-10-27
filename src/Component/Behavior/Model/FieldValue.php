<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Behavior\Model;

use Accard\Component\Field\Model\FieldValue as BaseFieldValue;

/**
 * Accard behavior field value model.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class FieldValue extends BaseFieldValue implements FieldValueInterface
{
    /**
     * {@inheritdoc}
     */
    public function getBehavior()
    {
        return parent::getSubject();
    }

    /**
     * {@inheritdoc}
     */
    public function setBehavior(BehaviorInterface $behavior = null)
    {
        return parent::setSubject($behavior);
    }
}
