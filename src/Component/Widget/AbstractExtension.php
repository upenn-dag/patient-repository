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

use Accard\Component\Widget\Exception\ExceptionInterface;
use Accard\Component\Widget\Exception\InvalidArgumentException;
use Accard\Component\Widget\Exception\UnexpectedTypeException;

/**
 * Abstract widget extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class AbstractExtension implements WidgetExtensionInterface
{
    /**
     * Widget types.
     *
     * @var array
     */
    private $widgetTypes;

    /**
     * {@inheritdoc}
     */
    public function getType($name)
    {
        if (null === $this->widgetTypes) {
            $this->initTypes();
        }

        if (!isset($this->widgetTypes[$name])) {
            throw new InvalidArgumentException(sprintf('The type %s can not be loaded by this extension.', $name));
        }

        return $this->widgetTypes[$name];
    }

    /**
     * {@inheritdoc}
     */
    public function hasType($name)
    {
        if (null === $this->widgetTypes) {
            $this->initTypes();
        }

        return isset($this->widgetTypes[$name]);
    }

    /**
     * Load widget types for this extension.
     *
     * @return array
     */
    protected function loadTypes()
    {
        return array();
    }

    /**
     * Initialize widget types.
     */
    private function initTypes()
    {
        $this->widgetTypes = array();

        foreach ($this->loadTypes() as $widgetType) {
            if (!$widgetType instanceof WidgetTypeInterface) {
                throw new UnexpectedTypeException($widgetType, 'Accard\Component\Widget\WidgetTypeInterface');
            }

            $this->widgetTypes[$widgetType->getName()] = $widgetType;
        }
    }
}
