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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;
use Accard\Component\Diagnosis\Repository\DiagnosisRepositoryInterface;

/**
 * Patient diagnoses listener.
 *
 * Listener pre-populates a the forms' diagnosis field with the correct values
 * for the selected patient.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientDiagnosesListener implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            FormEvents::POST_SUBMIT => 'buildForm',
            FormEvents::PRE_SET_DATA => 'buildForm',
        );
    }

    /**
     * Diagnosis repository.
     *
     * @var DiagnosisRepositoryInterface
     */
    protected $diagnosisRepository;


    /**
     * Constructor.
     *
     * @param DiagnosisRepositoryInterface $diagnosisRepositry
     */
    public function __construct(DiagnosisRepositoryInterface $diagnosisRepository)
    {
        $this->diagnosisRepository = $diagnosisRepository;
    }

    /**
     * Create all patient fields not already set.
     *
     * @param FormEvent $event
     */
    public function buildForm(FormEvent $event)
    {
        $activity = $event->getData();
        $qb = $event->getForm()->get('diagnosis')->getConfig()->getOption('query_builder');
        $qb = $qb($this->diagnosisRepository);

        // If no patient is present, only show unassigned diagnoses.
        if (null === $activity || null === $activity->getPatient()) {
            $qb->where('diagnosis.patient IS NULL');
            return;
        }

        // Otherwise, only show this patients' diagnoses.
        $qb
            ->resetDQLPart('where')
            ->where('diagnosis.patient = :patient')
            ->setParameter(':patient', $activity->getPatient())
        ;
    }
}
