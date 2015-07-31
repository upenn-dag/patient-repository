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

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use DAG\Bundle\ResourceBundle\Event\ResourceEvent;

/**
 * Phase persistence event subscriber.
 *
 * Phases are identified by a composite primary key, which creates issues when
 * attempting to persist a NEW subject along with new phases at the same time.
 * To get around this, we hook into the domain resource manger's event system
 * and persist the subject, by hand, first.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PhasePersistenceSubscriber implements EventSubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(
            'accard.patient.pre_create' => array('persistPhaseAssociation', 1),
            'accard.diagnosis.pre_create' => array('persistPhaseAssociation', 1),
        );
    }

    /**
     * Phase association persistence method.
     *
     * @param ResourceEvent $event
     */
    public function persistPhaseAssociation(ResourceEvent $event)
    {
        $om = $event['objectManager'];
        $subject = $event->getSubject();

        // If subject doesn't have phases, don't attempt.
        if (!method_exists($subject, 'getPhases')) {
            return;
        }

        $om->transactional(function ($om) use ($subject) {
            $phases = $subject->getPhases()->toArray();

            // Remove all phases BEFORE persisting subject.
            foreach ($phases as $phase) {
                $subject->removePhase($phase);
            }

            $om->persist($subject);
            $om->flush();

            // Add phases back into subject.
            foreach ($phases as $phase) {
                $subject->addPhase($phase);
                $om->persist($phase);
            }

            $om->persist($subject);
            $om->flush();
        });
    }
}
