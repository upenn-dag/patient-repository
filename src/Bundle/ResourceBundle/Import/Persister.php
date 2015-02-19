<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Import;

use Accard\Bundle\ResourceBundle\Import\Events;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Import Persister.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class Persister implements PersisterInterface
{
    /**
     * Persist Records
     *
     * @param ImportEvent $event
     */
    public function persist(ImportEvent $event)
    {
        $this->disableSQLLog($event);
        $this->persistImport($event);
        $this->persistRecords($event);
    }

    /**
     * Persists records to the target entity manager.
     *
     * @param ImportEvent $event
     */
    protected function persistRecords(ImportEvent $event)
    {
        $om = $event->getTarget()->getManager();
        $records = $event->getRecords();

        $om->transactional(function($om) use ($records) {
            foreach ($records as $record => $value ) {
                $om->persist($value);
            }
        });

        $om->flush();
    }

    /**
     * Persist import to target entity manager.
     *
     * This assumes that the import table is on the same database as the target
     * resource. This should be more flexible.
     *
     * @todo Allow seperate entity manager for import persistence.
     * @param ImportEvent $event
     */
    protected function persistImport(ImportEvent $event)
    {
        $om = $event->getTarget()->getManager();
        $import = $event->getImport();
        $import->setEndTimestamp();

        $om->persist($import);
    }

    /**
     * Disable SQL logger.
     *
     * @param ImportEvent $event
     */
    protected function disableSQLLog(ImportEvent $event)
    {
        $event->getTarget()->getManager()->getConnection()->getConfiguration()->setSQLLogger(null);
    }
}
