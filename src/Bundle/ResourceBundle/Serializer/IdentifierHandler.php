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

/**
 * JMS Serializer identifier handler.
 *
 * Used to convert objects to identifiers, and collections of objects to an
 * array of identifiers. Also supports deserialization of the same relationship.
 *
 * Note: This always assumes the identifier is an integer.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class IdentifierHandler implements SubscribingHandlerInterface
{
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
                'type' => 'id',
                'method' => 'serializeIdentifier'
            );
            $methods[] = array(
                'direction' => GraphNavigator::DIRECTION_DESERIALIZATION,
                'format' => $format,
                'type' => 'id',
                'method' => 'deserializeIdentifier'
            );
        }

        return $methods;
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
    public function serializeIdentifier(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        if (!is_object($data)) {
            return;
        }

        if ($this->isIterable($data)) {
            $identifiers = array();
            foreach ($data as $datum) {
                $identifiers[] = $this->getIdentifier($datum);
            }

            return $visitor->visitArray($identifiers, $type, $context);
        }

        return $visitor->visitInteger($this->getIdentifier($data), $type, $context);
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
     * @throws UnsupportedFormatException If Identifier can not be found.
     * @param mixed $data
     * @return integer
     */
    private function getIdentifier($data)
    {
        $refl = new ReflectionObject($data);
        if ($refl->hasMethod('getId')) {
            $refl = $refl->getMethod('getId');

            return $refl->invoke($data);
        }

        if ($refl->hasProperty('id')) {
            $refl = $refl->getProperty('id');
            $refl->setAccessible(true);

            return $refl->getValue($data);
        }

        throw new UnsupportedFormatException(sprintf(
            'Object for serialization of class "%s" has no identifier to be found. Tried getId() and id property through refleciton.',
            get_class($data)
        ));
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
    public function deserializeIdentifier(VisitorInterface $visitor, $data, array $type, Context $context)
    {
        throw new RuntimeException("Deserialization is not yet supported.");
    }
}
