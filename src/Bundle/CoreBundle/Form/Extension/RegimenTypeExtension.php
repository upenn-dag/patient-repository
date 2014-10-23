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
use Accard\Component\Activity\Repository\ActivityRepositoryInterface;
use Accard\Bundle\CoreBundle\Form\EventListener\PatientDiagnosesListener;
use Accard\Bundle\CoreBundle\Form\EventListener\DiagnosisActivitiesListener;

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
     * Activity class FQCN.
     *
     * @var string
     */
    protected $activityClass;

    /**
     * Activity repository.
     *
     * @var ActivityRepositoryInterface
     */
    protected $activityRepository;


    /**
     * Constructor.
     *
     * @param PatientRepositoryInterface $patientRepository
     * @param DiagnosisRepositoryInterface $diagnosisRepository
     * @param ActivityRepositoryInterface $activityRepository
     */
    public function __construct(PatientRepositoryInterface $patientRepository,
                                DiagnosisRepositoryInterface $diagnosisRepository,
                                ActivityRepositoryInterface $activityRepository)
    {
        $this->patientClass = $patientRepository->getClassName();
        $this->patientRepository = $patientRepository;
        $this->diagnosisClass = $diagnosisRepository->getClassName();
        $this->diagnosisRepository = $diagnosisRepository;
        $this->activityClass = $activityRepository->getClassName();
        $this->activityRepository = $activityRepository;
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

        if ($options['use_activities']) {
            $builder
                ->add('activities', 'collection', array(
                      'type' => 'accard_activity_choice',
                      'allow_add' => true,
                      'allow_delete' => true,
                      'by_reference' => false,
                ))
                ->addEventSubscriber(new DiagnosisActivitiesListener($this->activityRepository))
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
                'use_activities' => true,
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
