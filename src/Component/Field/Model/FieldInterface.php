<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Field\Model;

use Accard\Component\Option\Model\OptionInterface;
use Accard\Component\Resource\Model\ResourceInterface;

/**
 * Field interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldInterface extends ResourceInterface
{
    /**
     * Get name.
     *
     * @return string
     */
    public function getName();

    /**
     * Set name.
     *
     * @param string $name
     * @return FieldInterface
     */
    public function setName($name);

    /**
     * Get presentation name.
     *
     * @return string
     */
    public function getPresentation();

    /**
     * Set presentation name.
     *
     * @param string $presentation
     * @return FieldInterface
     */
    public function setPresentation($presentation);

    /**
     * Get field type.
     *
     * @return string
     */
    public function getType();

    /**
     * Set field type.
     *
     * @param string $type
     * @return FieldInterface
     */
    public function setType($type);

    /**
     * Get choice option.
     *
     * @return OptionInterface
     */
    public function getOption();

    /**
     * Set choice option.
     *
     * @param OptionInterface|null $option
     * @return FieldInterface
     */
    public function setOption(OptionInterface $option = null);

    /**
     * Test if multiple options are allowed.
     *
     * @return boolean
     */
    public function getAllowMultiple();

    /**
     * Set if multiple options are allowed.
     *
     * @param boolean $allowMultiple
     * @return FieldValueInterface
     */
    public function setAllowMultiple($allowMultiple);

    /**
     * Indicate values can be added inline for this field
     *
     * @return boolean
     */
    public function isAddable();

    /**
     * Set if values can be added inline for this field
     *
     * @param boolean $addable
     * @return FieldValueInterface
     */
    public function setAddable($addable);

    /**
     * Get order.
     *
     * @return string
     */
    public function getOrder();

    /**
     * Set order.
     *
     * @param string $order
     * @return FieldInterface
     */
    public function setOrder($order);

    /**
     * Get field configuration.
     *
     * @return array
     */
    public function getConfiguration();

    /**
     * Set field configuration.
     *
     * @param array $configuration
     * @return FieldInterface
     */
    public function setConfiguration(array $configuration);
}
