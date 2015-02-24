<?php
namespace Accard\Bundle\ResourceBundle\Import;

/**
 * Initializer Interface
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Event\ImportEvent;

interface InitializerInterface
{
	public function initialize(ImportEvent $event);
}