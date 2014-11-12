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

use Symfony\Component\OptionsResolver\Exception\InvalidOptionsException;

/**
 * Widget factory interface.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
interface WidgetFactoryInterface
{
    /**
     * Create a widget.
     *
     * @throws InvalidOptionsException If provided options are not allowed on the given type.
     * @param string|WidgetTypeInterface $type
     * @param mixed $data
     * @param array $options
     * @return WidgetInterface
     */
    public function create($type = 'widget', $data = null, array $options = array());

    /**
     * Create a named widget.
     *
     * @throws InvalidOptionsException If provided options are not allowed on the given type.
     * @param string $name
     * @param string|WidgetTypeInterface $type
     * @param mixed $data
     * @param array $options
     * @return WidgetInterface
     */
    public function createNamed($name, $type = 'widget', $data = null, array $options = array());

    /**
     * Create a widget builder.
     *
     * @throws InvalidOptionsException If provided options are not allowed on the given type.
     * @param string|WidgetTypeInterface $type
     * @param mixed $data
     * @param array $options
     * @return WidgetBuilderInterface
     */
    public function createBuilder($type = 'widget', $data = null, array $options = array());

    /**
     * Create a named widget builder.
     *
     * @throws InvalidOptionsException If provided options are not allowed on the given type.
     * @param string $name
     * @param string|WidgetTypeInterface $type
     * @param mixed $data
     * @param array $options
     * @return WidgetInterface
     */
    public function createNamedBuilder($name, $type = 'widget', $data = null, array $options = array());
}
