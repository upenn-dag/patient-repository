<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\SettingsBundle\Model;

/**
 * Basic settings parameter interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface ParameterInterface
{
    /**
     * Get settings namespace.
     *
     * @return string
     */
    public function getNamespace();

    /**
     * Set settings namespace.
     *
     * @param string $namespace
     * @return ParameterInterface
     */
    public function setNamespace($namespace);

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
     * @return ParameterInterface
     */
    public function setName($name);

    /**
     * Get value.
     *
     * @return mixed
     */
    public function getValue();

    /**
     * Set value.
     *
     * @param mixed $value
     * @return ParameterInterface
     */
    public function setValue($value);
}
