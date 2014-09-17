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

use DateTime;
use Accard\Component\Core\Model\PatientInterface;
use Accard\Component\Core\Model\PatientPhaseInstance;
use Doctrine\ORM\Event\PreUpdateEventArgs;
use Doctrine\ORM\Event\LifecycleEventArgs;

/**
 * Patient model entity listener.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PatientEntityListener
{
    /**
     * Pre-persist event listener.
     *
     * @param PatientInterface $patient
     * @param LifecycleEventArgs $event
     */
    public function prePersistHandler(PatientInterface $patient, LifecycleEventArgs $event)
    {
    }

    /**
     * Pre-update event listener.
     *
     * @param PatientInterface $patient
     * @param PreUpdateEventArgs $event
     */
    public function preUpdateHandler(PatientInterface $patient, PreUpdateEventArgs $event)
    {
    }

    /**
     * Pre-remove event listener.
     *
     * @param PatientInterface $patient
     * @param LifecycleEventArgs $event
     */
    public function preRemoveHandler(PatientInterface $patient, LifecycleEventArgs $event)
    {
        // Do remove stuff.
    }
}
