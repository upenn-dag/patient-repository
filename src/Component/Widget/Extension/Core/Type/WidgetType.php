<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Widget\Extension\Core\Type;

use Accard\Component\Widget\AbstractType;
use Accard\Component\Widget\WidgetBuilderInterface;
use Accard\Component\Widget\WidgetView;
use Accard\Component\Widget\WidgetInterface;
use Symfony\Component\PropertyAccess\PropertyAccess;
use Symfony\Component\PropertyAccess\PropertyAccessorInterface;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Base core widget type.
 *
 * Provides functionality common to all widgets, allowing us to build widgets
 * without duplicating the common functionality each time.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class WidgetType extends AbstractType
{
    /**
     * Property accessor.
     *
     * @var PropertyAccessorInterface
     */
    private $propertyAccessor;


    /**
     * Constructor.
     *
     * @param PropertyAccessorInterface
     */
    public function __construct(PropertyAccessorInterface $propertyAccessor = null)
    {
        $this->propertyAccessor = $propertyAccessor ?: PropertyAccess::createPropertyAccessor();
    }

    /**
     * {@inheritdoc}
     */
    public function buildWidget(WidgetBuilderInterface $builder, array $options)
    {
        $isDataOptionSet = array_key_exists('data', $options);

        $builder
            ->setAutoInitialize($options['auto_initialize'])
            ->setCompound($options['compound'])
            ->setData($isDataOptionSet ? $options['data'] : null)
            ->setEmptyData($options['empty_data'])
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(WidgetView $view, WidgetInterface $widget, array $options)
    {
        $name = $widget->getName();
        $blockName = $options['block_name'] ?: $widget->getName();
        $translationDomain = $options['translation_domain'];

        if ($view->parent) {
            if ('' !== ($parentFullName = $view->parent->vars['full_name'])) {
                $id = sprintf('%s_%s', $view->parent->vars['id'], $name);
                $fullName = sprintf('%s[%s]', $parentFullName, $name);
                $uniqueBlockPrefix = sprintf('%s_%s', $view->parent->vars['unique_block_prefix'], $blockName);
            } else {
                $id = $name;
                $fullName = $name;
                $uniqueBlockPrefix = '_'.$blockName;
            }

            if (!$translationDomain) {
                $translationDomain = $view->parent->vars['translation_domain'];
            }
        } else {
            $id = $name;
            $fullName = $name;
            $uniqueBlockPrefix = '_'.$blockName;

            // Strip leading underscores and digits. These are allowed in
            // widget names, but not in HTML4 ID attributes.
            // http://www.w3.org/TR/html401/struct/global.html#adef-id
            $id = ltrim($id, '_0123456789');
        }

        $blockPrefixes = array();
        for ($type = $widget->getConfig()->getType(); null !== $type; $type = $type->getParent()) {
            array_unshift($blockPrefixes, $type->getName());
        }
        $blockPrefixes[] = $uniqueBlockPrefix;

        if (!$translationDomain) {
            $translationDomain = 'messages';
        }

        $view->vars = array_replace($view->vars, array(
            'attr' => $options['attr'],
            'block_prefixes' => $blockPrefixes,
            'cache_key' => $uniqueBlockPrefix.'_'.$widget->getConfig()->getType()->getName(),
            //'children' => $view->children,
            'compound' => $widget->getConfig()->getCompound(),
            'data' => $widget->getData(),
            'full_name' => $fullName,
            'id' => $id,
            'name' => $name,
            'translation_domain' => $translationDomain,
            'type' => $widget->getConfig()->getType()->getName(),
            'unique_block_prefix' => $uniqueBlockPrefix,
            'widget' => $view,
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function finishView(WidgetView $view, WidgetInterface $widget, array $options)
    {
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        // Derive "empty_data" closure from "data_class" option
        $emptyData = function (Options $options) {
            return function (WidgetInterface $form) {
                return $form->getConfig()->getCompound() ? array() : '';
            };
        };

        $resolver->setDefaults(array(
            'accessor' => $this->propertyAccessor,
            'attr' => array(),
            'auto_initialize' => true,
            'block_name' => null,
            'compound' => true,
            'empty_data' => $emptyData,
            'inherit_data' => false,
            'translation_domain' => null,
            'type' => null,
        ));

        $resolver->setOptional(array('data'));

        $resolver->setAllowedTypes(array(
            'attr' => 'array',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'widget';
    }
}
