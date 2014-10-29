<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Exception;

use Symfony\Component\Form\Exception\InvalidArgumentException;

/**
 * Unexpected type exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class UnexpectedTypeException extends InvalidArgumentException
{
    /**
     * {@inheritdoc}
     */
    public function __construct($value, $expectedType)
    {
        parent::__construct(sprintf('Expected argument of type "%s", "%s" given', $expectedType, is_object($value) ? get_class($value) : gettype($value)));
    }
}
