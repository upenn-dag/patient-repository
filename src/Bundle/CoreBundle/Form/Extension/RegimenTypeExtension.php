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
use Accard\Component\Patient\Repository\PatientRepositoryInterface;
use Accard\Component\Diagnosis\Repository\DiagnosisRepositoryInterface;
use Accard\Bundle\CoreBundle\Form\EventListener\PatientDiagnosesListener;

/**
 * Regimen form type extension.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenTypeExtension extends AbstractTypeExtension
{
    /**
     * Patient class FQCN.
     *
     * @var string
     */
    protected $patientClass;

    /**
     * Patient repository.
     *
     * @var PatientRepositoryInterface
     */
    protected $patientRepository;

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
    public function __construct(PatientRepositoryInterface $patientRepository, DiagnosisRepositoryInterface $diagnosisRepository)
    {
        $this->patientClass = $patientRepository->getClassName();
        $this->patientRepository = $patientRepository;
        $this->diagnosisClass = $diagnosisRepository->getClassName();
        $this->diagnosisRepository = $diagnosisRepository;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if ($options['use_patient']) {
            $builder->add('patient', 'accard_patient_choice');
        }

        if ($options['use_diagnosis']) {
            $builder
                ->add('diagnosis', 'accard_diagnosis_choice', array('required' => false))
                ->addEventSubscriber(new PatientDiagnosesListener($this->diagnosisRepository))
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
                'use_patient' => true,
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