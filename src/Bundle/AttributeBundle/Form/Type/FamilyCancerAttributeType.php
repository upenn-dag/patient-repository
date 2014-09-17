<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\AttributeBundle\Form\Type;

use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Bundle\DiagnosisBundle\Provider\CodeProvider;
/**
 * Attribute Family Cancer form type.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class FamilyCancerAttributeType extends AttributeType
{
    /**
     * Translator.
     *
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * code group provider.
     *
     * @var CodeProvider
     */
    private $codeProvider;

    /**
     * Set code provider.
     *
     * @param CodeProvider
     */
    public function setCodeProvider(CodeProvider $codeProvider)
    {
        $this->codeProvider = $codeProvider;
    }

    /**
     * Set translator.
     *
     * @param TranslatorInterface
     */
    public function setTranslator(TranslatorInterface $translator)
    {
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if (null === $this->translator) {
            throw new \LogicException('Translator must be present when constructing the family cancer attribute form type.');
        }

        if (null === $this->codeProvider) {
            throw new \LogicException('Code Group must be present when constructing the family cancer attribute form type.');
        }

        $codeClass = $this->codeProvider->getRepository()->getClassName();
        $codeChoices = $this->codeProvider->getCodesForGroup($options['code_group']);


        $builder
            ->add('familyMember', 'choice', array(
                'label'         => $this->translator->trans('accard.attribute.family_cancer.form.familyMember'),
                'required'      => true,
                'choices'           =>      array(
                    'Mother'            =>      $this->translator->trans('accard.attribute.family_cancer.form.family.mother'),
                    'Father'            =>      $this->translator->trans('accard.attribute.family_cancer.form.family.father'),
                    'Sister'            =>      $this->translator->trans('accard.attribute.family_cancer.form.family.sister'),
                    'Brother'           =>      $this->translator->trans('accard.attribute.family_cancer.form.family.brother'),
                    'Grandfather'       =>      $this->translator->trans('accard.attribute.family_cancer.form.family.grandfather'),
                    'Grandmother'       =>      $this->translator->trans('accard.attribute.family_cancer.form.family.grandmother'),
                    'Aunt'              =>      $this->translator->trans('accard.attribute.family_cancer.form.family.aunt'),
                    'Uncle'             =>      $this->translator->trans('accard.attribute.family_cancer.form.family.uncle'),
                    'Cousin'            =>      $this->translator->trans('accard.attribute.family_cancer.form.family.cousin')
                )
            ))
            ->add('side', 'choice', array(
                'label'         => $this->translator->trans('accard.attribute.family_cancer.form.side'),
                'required'      => true,
                'choices'           =>      array(
                    'Mother'            =>      $this->translator->trans('accard.attribute.family_cancer.form.mothers_side'),
                    'Father'            =>      $this->translator->trans('accard.attribute.family_cancer.form.fathers_side')
                )
            ))
            ->add('code', 'entity', array(
                'label'         =>       'accard.attribute.family_cancer.form.code',
                'class'         =>       $codeClass,
                'choices'       =>       $codeChoices,
                'property'      =>       'description',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'data_class' => $this->dataClass,
                'validation_groups' => $this->validationGroups,
                'code_group' => 'family_cancer',
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getParent()
    {
        return 'accard_attribute';
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'accard_family_cancer_attribute';
    }
}
