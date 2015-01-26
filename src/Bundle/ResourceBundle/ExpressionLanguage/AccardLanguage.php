<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\ExpressionLanguage;

use LogicException;
use InvalidArgumentException;
use Accard\Component\Resource\Model\ResourceInterface;
use Accard\Component\Prototype\Model\PrototypeSubjectInterface;

/**
 * Accard expression language singleton.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
final class AccardLanguage
{
    /**
     * Singletone instance.
     *
     * @var self
     */
    private static $instance;

    /**
     * Expression language instance.
     *
     * @var ExpressionLanguage
     */
    private static $exprLanguage;

    /**
     * Set expression language.
     *
     * @param ExpressionLanguage $exprLanguage
     */
    public static function setExpressionLanguage(ExpressionLanguage $exprLanguage)
    {
        static::$exprLanguage = $exprLanguage;
    }

    /**
     * Singleton Accard language instance.
     *
     * @return self
     */
    public static function getInstance()
    {
        if (null === static::$exprLanguage) {
            throw new LogicException('Expression lanaguage must be set prior to calling Accard language component.');
        }

        if (null === static::$instance) {
            static::$instance = new self(static::$exprLanguage);
        }

        return static::$instance;
    }

    /**
     * Create prototype description.
     *
     * @param ResourceInterface $resource
     * @throws InvalidArgumentException If resource is not prototyped.
     * @return string
     */
    public function createPrototypeDescription(ResourceInterface $resource)
    {
        if (!$resource instanceof PrototypeSubjectInterface) {
            throw new InvalidArgumentException('Resources passed to prototype descriptor must be an instance of PrototypeSubjectInterface.');
        }

        $template = $resource->getPrototype()->getDescription();

        return $this->getExpressionLanguage()->evaluate($template, array('resource' => $resource));
    }

    /**
     * Get the current expression language.
     *
     * @return ExpressionLanguage
     */
    public function getExpressionLanguage()
    {
        $this->assertExpressionLanguage();

        return static::$exprLanguage;
    }

    /**
     * Assert that expression language has been set.
     *
     * @throws LogicException
     */
    private function assertExpressionLanguage()
    {
        if (null === static::$exprLanguage) {
            throw new LogicException('Expression lanaguage must be set prior to calling Accard language component.');
        }
    }
}
