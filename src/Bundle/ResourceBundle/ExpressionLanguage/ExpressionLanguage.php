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

use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage as BaseExpressionLanguage;


/**
 * Resource specific implementation of the Symfony expression language.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ExpressionLanguage extends BaseExpressionLanguage implements ContainerAwareInterface
{
    /**
     * Expression values.
     *
     * @var array
     */
    protected $values = array();


    /**
     * {@inheritdoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->values = array_merge($this->values, array('container' => $container));
    }

    /**
     * Register expression value.
     *
     * Expression values are fed into the expression at runtime and serve as
     * usable variables in all expressions.
     *
     * @param string $name
     * @param mixed $value
     */
    public function registerValue($name, $value)
    {
        $this->values[$name] = $value;
    }

    /**
     * Register expression extension.
     *
     * This is a proprietary addition to the expression language, enabling dynamic
     * extension of the domain specific expression language.
     *
     * @param ExtensionInterface $extension
     */
    public function registerExtension(ExtensionInterface $extension)
    {
        if ($extension instanceof ContainerAwareInterface) {
            $extension->setContainer($this->values['container']);
        }

        foreach ($extension->getFunctions() as $function) {
            $this->register($function[0], $function[1], $function[2]);
        }

        foreach ($extension->getValues() as $key => $value) {
            $this->registerValue($key, $value);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function evaluate($expression, $values = array())
    {
        return parent::evaluate($expression, array_merge($this->values, $values));
    }

    /**
     * {@inheritdoc}
     */
    protected function registerFunctions()
    {
        parent::registerFunctions();

        $this->register('service', function ($arg) {
            return sprintf('$this->get(%s)', $arg);
        }, function (array $variables, $value) {
            return $variables['container']->get($value);
        });

        $this->register('parameter', function ($arg) {
            return sprintf('$this->getParameter(%s)', $arg);
        }, function (array $variables, $value) {
            return $variables['container']->getParameter($value);
        });
    }
}
