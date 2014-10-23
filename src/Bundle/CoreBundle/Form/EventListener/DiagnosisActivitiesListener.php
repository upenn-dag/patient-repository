<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Form\EventListener;

use DateTime;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Accard\Component\Activity\Repository\ActivityRepositoryInterface;

/**
 * Diagnosis activities listener.
 *
 * Listener pre-populates a the forms' activity field with the correct values
 * for the selected diagnosis.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DiagnosisActivitiesListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::PRE_SET_DATA => 'buildForm',
        );
    }

    /**
     * Activity repository.
     *
     * @var ActivityRepositoryInterface
     */
    protected $activityRepository;


    /**
     * Constructor.
     *
     * @param ActivityRepositoryInterface $activityRepositry
     */
    public function __construct(ActivityRepositoryInterface $activityRepository)
    {
        $this->activityRepository = $activityRepository;
    }

    /**
     * Create all diagnosis fields not already set.
     *
     * @param FormEvent $event
     */
    public function buildForm(FormEvent $event)
    {
        $regimen = $event->getData();

        if ($regimen->getId()) {
            $event->getForm()->remove('patient');
        }

        $config = $event->getForm()->get('activities')->getConfig();
        $type = $config->getType()->getName();
        $options = $config->getOptions();
        $qb = $options['options']['query_builder'] = $this->activityRepository->getQueryBuilder();

        // If no diagnosis is present, look for patient.
        if (null === $regimen || null === $regimen->getDiagnosis()) {
            if (null === $regimen->getPatient()) {
                $qb->andWhere('activity.patient IS NULL');
                $qb->andWhere('activity.diagnosis IS NULL');
            } else {
                $qb->andWhere('activity.patient = :patient');
                $qb->andWhere('activity.diagnosis IS NULL');
                $qb->setParameter(':patient', $regimen->getPatient());
            }
        } else {
            $qb
                ->resetDQLPart('where')
                ->where('activity.diagnosis = :diagnosis')
                ->setParameter(':diagnosis', $regimen->getDiagnosis())
            ;
        }

        if (($startDate = $regimen->getStartDate()) instanceof DateTime) {
            $qb->andWhere('activity.activityDate >= :startDate')->setParameter(':startDate', $startDate);
        }

        if (($endDate = $regimen->getEndDate()) instanceof DateTime) {
            $qb->andWhere('activity.activityDate <= :endDate')->setParameter(':endDate', $endDate);
        }

        $event->getForm()->add('activities', $type, $options);
    }
}
