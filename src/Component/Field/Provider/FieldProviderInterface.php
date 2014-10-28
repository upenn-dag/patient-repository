<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Field\Provider;

use Doctrine\Common\Collections\Collection;
use Accard\Component\Field\Model\FieldInterface;
use Accard\Component\Field\Exception\FieldNotFoundException;

/**
 * Field provider interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldProviderInterface
{
    /**
     * Get all prototypes.
     *
     * @return Collection|FieldInterface[]
     */
    public function getFields();

    /**
     * Get model class.
     *
     * @return string
     */
    public function getFieldModelClass();

    /**
     * Test for presence of prototype by id.
     *
     * @param integer $fieldId
     * @return boolean
     */
    public function hasField($fieldId);

    /**
     * Get prototype by id.
     *
     * @throws FieldNotFoundException If prototype can not be found.
     * @param integer $fieldId
     * @return FieldInterface
     */
    public function getField($fieldId);

    /**
     * Test for presence of prototype by name.
     *
     * @param string $fieldName
     * @return boolean
     */
    public function hasFieldByName($fieldName);

    /**
     * Get prototype by name.
     *
     * @throws FieldNotFoundException If prototype can not be found.
     * @param string $fieldName
     * @return FieldInterface
     */
    public function getFieldByName($fieldName);
}
