<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Storage;

/**
 * Storage interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface StorageInterface
{
    /**
     * Initializes storage.
     *
     * @param string $domain
     */
    public function initialize($domain);

    /**
     * Test for storage value for a key.
     *
     * @param string $key
     * @return boolean
     */
    public function has($key);

    /**
     * Get value for key.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed|null
     */
    public function get($key, $default = null);

    /**
     * Set value for key.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);

    /**
     * Remove value for key.
     *
     * @param string $key
     */
    public function remove($key);

    /**
     * Clear all values.
     */
    public function clear();
}
