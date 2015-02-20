<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PrototypeBundle;

use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * Prototype describer, static implementation.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeDescriber
{
    /**
     * Singleton instance.
     * 
     * @var self
     */
    private static $instance;


    /**
     * Static access to singleton instance.
     * 
     * @return self
     */
    public static function instance()
    {
        if (!static::$instance instanceof self) {
            $accessor = PropertyAccess::createPropertyAccessor();
            static::$instance = new self($accessor);
        }

        return static::$instance;
    }

    /**
     * Property accessor.
     * 
     * @var
     */ 
    private $accessor;

    /**
     * Private constructor.
     * 
     * @param PropertyAccessor $accessor
     */
    private function __construct(PropertyAccessor $accessor)
    {

    }
}
