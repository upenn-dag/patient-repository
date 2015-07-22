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

use DAG\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;

/**
 * Behavior behavior field value model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldValueInterface extends BaseFieldValueInterface
{
    /**
     * Get behavior.
     *
     * @return BehaviorInterface|null
     */
    public function getBehavior();

    /**
     * Set behavior.
     *
     * @param BehaviorInterface|null $behavior
     * @return FieldValueInterface
     */
    public function setBehavior(BehaviorInterface $behavior = null);
}
