<?php
namespace Accard\Bundle\ResourceBundle\Import;

/**
 * Resource \ Import \ Default Converter
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\ConverterInterface;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;

class Converter implements ConverterInterface
{
	/**
	 * Converter placeholder
	 * 
	 * @param ImportEvent $event
	 * @return void
	 */
	public function convert(ImportEvent $event)
	{

	}
}