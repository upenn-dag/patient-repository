<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget;

use Accard\Component\Widget\Exception\InvalidArgumentException;

/**
 * Preloaded widget extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PreloadedWidgetExtension implements WidgetExtensionInterface
{
    /**
     * Types.
     *
     * @var WidgetTypeInterface[]
     */
    private $types = array();


    /**
     * Constructor.
     *
     * @param WidgetTypeInterface[]
     */
    public function __construct(array $types)
    {
        $this->types = $types;
    }

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (!$this->hasType($name)) {
            throw new InvalidArgumentException(sprintf('The type "%s" can not be loaded by this extension.', $name));
        }

        return $this->types[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        return isset($this->types[$name]);
    }
}
