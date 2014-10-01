<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\PrototypeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;

/**
 * Accard prototype choice type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PrototypeChoiceType extends AbstractType
{
    /**
     * Subject name.
     *
     * @var string
     */
    protected $subjectName;

    /**
     * Prototype provider.
     * 
     * @var PrototypeProviderInterface
     */
    protected $provider;


    /**
     * Constructor.
     *
     * @param string $subjectName
     * @param PrototypeProviderInterface $provider
     */
    public function __construct($subjectName, PrototypeProviderInterface $provider)
    {
        $this->subjectName = $subjectName;
        $this->provider = $provider;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'class' => $this->provider->getModelClass(),
                'choices' => $this->provider->getAll(),
                'property' => 'presentation',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'entity';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return sprintf('accard_%s_prototype_choice', $this->subjectName);
    }
}
