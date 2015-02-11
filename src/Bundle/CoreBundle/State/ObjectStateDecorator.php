<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\State;

/**
 * Object state decorator.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
abstract class ObjectStateDecorator implements ObjectStateInterface
{
    /**
     * Object state.
     *
     * @var ObjectStateInterface
     */
    private $objectState;


    /**
     * Decorator constructor.
     *
     * @param ObjectStateInterface $objectState
     */
    public function __construct(ObjectStateInterface $objectState)
    {
        $this->objectState = $objectState;
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize()
    {
        return $this->objectState->jsonSerialize();
    }

    /**
     * {@inheritdoc}
     */
    public function __sleep()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function __call($method, array $args)
    {
        if (!method_exists($this->objectState, $method)) {
            throw new \BadMethodCallException();
        }

        return call_user_func_array(array($this->objectState, $method), $args);
    }
}
