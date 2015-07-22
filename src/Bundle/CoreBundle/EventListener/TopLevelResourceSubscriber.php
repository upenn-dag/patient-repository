<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\EventListener;

use DAG\Bundle\ResourceBundle\Event\ResourceEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Top level resource event subscriber.
 *
 * Provides listeners to top level resource entities (patient, diagnosis) to
 * change the way they are persisted or removed.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class TopLevelResourceSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'accard.diagnosis.pre_delete' => 'preDeleteDiagnosis',
            'accard.patient.pre_delete' => 'preDeletePatient',
        );
    }

    /**
     * Pre delete patient.
     *
     * Stops a patient from being deleted if it contains second level data.
     *
     * @param ResourceEvent $event
     */
    public function preDeletePatient(ResourceEvent $event)
    {
        $patient = $event->getSubject();
        $hasDiagnoses = (boolean) count($patient->getDiagnoses());
        $hasActivities = (boolean) count($patient->getActivities());
        $hasAttributes = (boolean) count($patient->getAttributes());
        $hasBehaviors = (boolean) count($patient->getBehaviors());
        $hasRegimens = (boolean) count($patient->getRegimens());

        if ($hasDiagnoses || $hasActivities || $hasAttributes || $hasBehaviors || $hasRegimens) {
            $entities = array();
            $hasDiagnoses && $entities[] = 'diagnoses';
            $hasActivities && $entities[] = 'activities';
            $hasAttributes && $entities[] = 'attributes';
            $hasBehaviors && $entities[] = 'behaviors';
            $hasRegimens && $entities[] = 'regimens';

            $string = $this->createEntityString($entities);

            $event->stop('accard.flashes.no_delete', 'warning', array('%entities%' => $string));
        }
    }

    private function createEntityString(array $entities)
    {
        $count = count($entities);

        if (1 === $count) {
            return array_shift($entities);
        } elseif (2 === $count) {
            return implode(' and ', $entities);
        }

        $last = array_pop($entities);
        $string = implode(', ', $entities);

        return sprintf('%s, and %s', $string, $last);
    }

    /**
     * Pre delete diagnosis.
     *
     * Stops a diagnosis from being deleted if it contains second level data.
     *
     * @param ResourceEvent $event
     */
    public function preDeleteDiagnosis(ResourceEvent $event)
    {
        $diagnosis = $event->getSubject();
        $hasActivities = (boolean) count($diagnosis->getActivities());
        $hasRegimens = (boolean) count($diagnosis->getRegimens());

        if ($hasActivities || $hasRegimens) {
            $entities = array();
            $hasActivities && $entities[] = 'activities';
            $hasRegimens && $entities[] = 'regimens';

            $string = $this->createEntityString($entities);

            $event->stop('accard.flashes.no_delete', 'warning', array('%entities%' => $string));
        }
    }
}
