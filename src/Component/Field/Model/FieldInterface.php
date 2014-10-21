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

/**
 * Field interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface FieldInterface
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
     * @param OptionInterface $option
     * @return FieldInterface
     */
    public function setOption(OptionInterface $option);

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
