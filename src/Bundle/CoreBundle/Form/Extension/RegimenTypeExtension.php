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
        // Attempt to grab existing data...
        $regimen = isset($options['data']) ? $options['data'] : null;
        $disableFields = false;
        $patient = false;
        $diagnosis = false;

        if ($regimen) {
            if ($regimen->getPatient()) {
                $disableFields = true;
                $patient = $regimen->getPatient();
            }

            if ($regimen->getDiagnosis()) {
                $diagnosis = $regimen->getDiagnosis();
            }
        }

        $disablePt = (boolean) $patient;
        $disableDx = (boolean) $diagnosis;

        if ($options['use_patient']) {
            $builder->add('patient', 'accard_patient_choice', array(
                'disabled' => $disablePt,
            ));
        }

        if ($options['use_diagnosis']) {
            $builder
                ->add('diagnosis', 'accard_diagnosis_choice', array(
                    'required' => false,
                    'disabled' => $disableDx,
                ))
                ->addEventSubscriber(new PatientDiagnosesListener($this->diagnosisRepository))
            ;
        }

        $activitiesAllowed = ($regimen && (($patient && $diagnosis) || $diagnosis));

        if ($activitiesAllowed && $options['use_activities']) {

            $queryBuilder = function(EntityRepository $er) use ($regimen) {
                $qb = $er->getQueryBuilder();

                if ($regimen->getDiagnosis()) {
                    $where = $qb->expr()->eq('activity.diagnosis', ':diagnosis');
                    $qb->setParameter('diagnosis', $regimen->getDiagnosis());
                } else {
                    $where = $qb->expr()->eq('activity.patient', ':patient');
                    $qb->setParameter('patient', $regimen->getPatient());
                }

                if ($regimen->getId()) {
                    $qb->where(
                        $qb->expr()->orX(
                            $qb->expr()->andX(
                                $qb->expr()->isNull('activity.regimen'),
                                $where
                            ),
                            $qb->expr()->andX(
                                $qb->expr()->eq('activity.regimen', ':regimen'),
                                $where
                            )
                        )
                    );

                    $qb->setParameter('regimen', $regimen);
                } else {
                    $qb->where(
                        $qb->expr()->andX(
                            $qb->expr()->isNull('activity.regimen'),
                            $where
                        )
                    );
                }

                return $qb;
            };

            $builder
                ->add('activities', 'accard_activity_choice', array(
                    'multiple' => true,
                    'expanded' => true,
                    'query_builder' => $queryBuilder,
                    'by_reference' => false,
                ))
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
                'use_patient' => false,
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
