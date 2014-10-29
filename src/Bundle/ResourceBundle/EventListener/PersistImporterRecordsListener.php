<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\EventListener;

use Accard\Bundle\ResourceBundle\Import\Events;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Symfony\Component\PropertyAccess\PropertyAccess;

/**
 * Persist importer records listener.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class PersistImporterRecordsListener
{
    /**
     * Persists records to the target entity manager.
     *
     * @param ImportEvent $event
     */
    public function persistRecords(ImportEvent $event)
    {
        $om = $event->getTarget()->getManager();
        $records = $event->getRecords();


        $om->transactional(function($om) use ($records) {
            foreach ($records as $record => $value ) {
                //die(var_dump($record));
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
    public function persistImport(ImportEvent $event)
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
    public function disableSQLLog(ImportEvent $event)
    {
        $event->getTarget()->getManager()->getConnection()->getConfiguration()->setSQLLogger(null);
    }
}
