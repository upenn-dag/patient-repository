<?php
namespace Accard\Bundle\PDSBundle\Import\Common;

/**
 * PDS \ Import \ Common \ Converter
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
use Accard\Bundle\ResourceBundle\Import\ConverterInterface;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Bundle\ResourceBundle\Import\Resource;
use DateTime;

class Converter implements ConverterInterface
{
	/**
	 * Convert.
	 *
	 * @param array $records
	 * @return void
	 */
	public function convert(ImportEvent $event)
	{
		$records = $event->getRecords();
		$flattened = array();

		foreach($records as $key => $value) {
			foreach($value as $possibleObject) {
				if(is_object($possibleObject) && !$possibleObject instanceOf Resource && !$possibleObject instanceOf DateTime) {
					$flattened[] = $possibleObject;
				}
			}
			unset($records[$key]);
		}

		$event->setRecords($flattened);
	}
}