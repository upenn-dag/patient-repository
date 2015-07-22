<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Attribute\Model;

use DAG\Component\Field\Model\FieldValueInterface as BaseFieldValueInterface;

/**
 * Attribute attribute field value model interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldValueInterface extends BaseFieldValueInterface
{
    /**
     * Get attribute.
     *
     * @return AttributeInterface|null
     */
    public function getAttribute();

    /**
     * Set attribute.
     *
     * @param AttributeInterface|null $attribute
     * @return FieldValueInterface
     */
    public function setAttribute(AttributeInterface $attribute = null);
}
