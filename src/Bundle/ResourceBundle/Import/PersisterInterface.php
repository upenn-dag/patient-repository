<?php
namespace Accard\Bundle\ResourceBundle\Import;

/**
 * Persister Interface
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Event\ImportEvent;

interface PersisterInterface
{
	public function persist(ImportEvent $event);
}