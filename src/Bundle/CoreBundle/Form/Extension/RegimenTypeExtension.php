<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Form\Extension;

use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Accard\Component\Diagnosis\Repository\DiagnosisRepositoryInterface;

/**
 * Regimen form type extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenTypeExtension extends AbstractTypeExtension
{
    /**
     * Diagnosis class FQCN.
     *
     * @var string
     */
    protected $diagnosisClass;

    /**
     * Diagnosis repository.
     *
     * @var DiagnosisRepositoryInterface
     */
    protected $diagnosisRepository;


    /**
     * Constructor.
     *
     * @param DiagnosisRepositoryInterface $diagnosisRepository
     */
    public function __construct(DiagnosisRepositoryInterface $diagnosisRepository)
    {
        $this->diagnosisClass = $diagnosisRepository->getClassName();
        $this->diagnosisRepository = $diagnosisRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['use_diagnosis']) {
            $builder
                ->add('diagnosis', 'accard_diagnosis_choice')
                //->addEventSubscriber(new PatientDiagnosesListener($this->diagnosisRepository))
            ;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver
            ->setDefaults(array(
                'use_diagnosis' => true,
            ))
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function getExtendedType()
    {
        return 'accard_regimen';
    }
}
