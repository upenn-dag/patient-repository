<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Form\Type;

use Doctrine\Common\Persistence\ManagerRegistry;
use Accard\Bundle\ResourceBundle\Form\DataTransformer\ObjectToIdentifierTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Exception\InvalidConfigurationException;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Typeahead type.
 * 
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TypeaheadType extends AbstractType
{
    /**
     * Object manager.
     * 
     * @var ManagerRegistry
     */
    private $managerRegistry;

    /**
     * Constructor.
     * 
     * @param ManagerRegistry $managerRegistry
     */
    public function __construct(ManagerRegistry $managerRegistry)
    {
        $this->managerRegistry = $managerRegistry;
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $view->vars['block_prefixes'][] = 'typeahead';
        $view->vars['typeahead'] = array(
            'id_property' => $options['id_property'],
            'property' => $options['property'],
            'route' => $options['route'],
            'route_params' => $options['route_params']
        );
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (empty($options['class'])) {
            throw new InvalidConfigurationException('Option "class" must be set.');
        }
        $transformer = new ObjectToIdentifierTransformer(
            $this->managerRegistry->getManager($options['entity_manager'])->getRepository($options['class']),
            $options['class']
        );
        $builder->addModelTransformer($transformer);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'id_property'     => 'id',
            'route_params'    => array(),
            'entity_manager'  => 'default',
            'invalid_message' => 'The selected item does not exist',
        ));

        $resolver
            ->setRequired(array('class', 'id_property', 'property', 'route'))
            ->setOptional(array('route_params'))
            ->setAllowedTypes(array(
                'class' => array('string'),
                'id_property' => array('string'),
                'property' => array('string'),
                'route' => array('string'),
                'route_params' => array('array'),
                'entity_manager' => array('string'),
                'invalid_message' => array('string'),
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'text';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_typeahead';
    }
}
