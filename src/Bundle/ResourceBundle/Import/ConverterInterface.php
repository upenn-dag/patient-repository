<?php
namespace Accard\Bundle\ResourceBundle\Import;

/**
 * Converter Interface
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Event\ImportEvent;

interface ConverterInterface
{
	public function convert(ImportEvent $event);
}