<?php
namespace Accard\Bundle\TemplateBundle\Form\Type;

/**
 * Template Form Type
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class TemplateType extends AbstractType
{
    private $bundles = array(
        'AccardTemplateBundle' => 'AccardTemplateBundle',
    );

    private $defaultBundle = 'AccardTemplateBundle';

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', 'text')
            ->add('location', 'text')
            ->add('content', 'textarea')
            ->add('parent', 'choice', array(
                'choices' => $options['bundle_choices'],
                'placeholder' => 'accard.template.choose_parent',
            ))
            ->add('save', 'submit');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'bundle_choices' => $this->bundles,
            'default_bundle' => $this->defaultBundle,
        ));
    }

    public function getName()
    {
        return 'template';
    }
}
