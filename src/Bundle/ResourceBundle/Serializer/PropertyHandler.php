<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Serializer;

use ReflectionObject;
use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\VisitorInterface;
use Doctrine\Common\Collections\Collection;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\Exception\RuntimeException;
use JMS\Serializer\Exception\UnsupportedFormatException;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessor;

/**
 * JMS Serializer property handler.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PropertyHandler implements SubscribingHandlerInterface
{
    /**
     * Property accessor.
     *
     * @var PropertyAccessor
     */
    protected static $propertyAccessor;

    /**
     * {@inheritdoc}
     */
    public static function getSubscribingMethods()
    {
        $methods = array();
        $formats = array('json', 'xml', 'yml');

        foreach ($formats as $format) {
            $methods[] = array(
                'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
                'format' => $format,
                'type' => 'property',
                'method' => 'serializeProperty'
            );
            $methods[] = array(
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => $format,
                'type' => 'property',
                'method' => 'deserializeProperty'
            );
        }

        return $methods;
    }

    protected $propertyPath;

    /**
     * Constructor.
     */
    public function __construct()
    {
        if (null === static::$propertyAccessor) {
            static::$propertyAccessor = PropertyAccess::createPropertyAccessor();
        }
    }

    /**
     * Serialize identifier(s).
     *
     * Converts an object or collection of objects to an id or array of ids.
     *
     * @param VisitorInterface $visitor
     * @param mixed $data
     * @param array $type
     * @param Context $context
     * @return
     */
    public function serializeProperty(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        if (!is_object($data)) {
            return;
        }

        if ($this->isIterable($data)) {
            $identifiers = array();
            foreach ($data as $datum) {
                $identifiers[] = $this->getProperty($datum, $type);
            }

            return $visitor->visitArray($identifiers, $type, $context);
        }

        return $visitor->visitString($this->getProperty($data, $type), $type, $context);
    }

    /**
     * Test if input is iterable.
     *
     * @param mixed $data
     * @return boolean
     */
    private function isIterable($data)
    {
        return is_array($data) || $data instanceof Traversable || $data instanceof Collection;
    }

    /**
     * Get identifier through any means possible.
     *
     * @param mixed $data
     * @param array $type
     * @return integer
     */
    private function getProperty($data, array $type)
    {
        $path = isset($type['params'][0]) ? $type['params'][0] : 'id';

        return static::$propertyAccessor->getValue($data, $path);
    }

    /**
     * Deserialize identifier(s).
     *
     * Converts an id or array of ids to an object or collection of objects.
     *
     * @throws RuntimeException Until this is implemented.
     * @param VisitorInterface $visitor
     * @param mixed $data
     * @param array $type
     * @param Context $context
     * @return
     */
    public function deserializeProperty(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        throw new RuntimeException("Deserialization is not yet supported.");
    }
}
