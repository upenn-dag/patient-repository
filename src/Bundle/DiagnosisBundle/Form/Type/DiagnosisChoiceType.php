<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\DiagnosisBundle\Form\Type;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Diagnosis\Repository\DiagnosisRepositoryInterface;
use DAG\Bundle\ResourceBundle\Form\DataTransformer\ObjectToIdentifierTransformer;
use DAG\Bundle\ResourceBundle\Form\DataTransformer\IdentifierToObjectTransformer;

/**
 * Diagnosis choice form type.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisChoiceType extends AbstractType
{
    /**
     * Data class.
     *
     * @var string
     */
    protected $dataClass;

    /**
     * Diagnosis repository.
     *
     * @var DiagnosisRepositoryInterface
     */
    protected $diagnosisRepository;


    /**
     * Constructor.
     *
     * @param string $dataClass
     */
    public function __construct($dataClass,
                                DiagnosisRepositoryInterface $diagnosisRepository)
    {
        $this->dataClass = $dataClass;
        $this->diagnosisRepository = $diagnosisRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'class' => $this->dataClass,
                'property' => 'canonical',
                'label' => 'accard.diagnosis.entity_name',
                'query_builder' => function (EntityRepository $er) {
                    static $qb;
                    return $qb = $er->getQueryBuilder();
                },
                'empty_value' => 'accard.diagnosis.form.select_diagnosis'
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
        return 'accard_diagnosis_choice';
    }
}
