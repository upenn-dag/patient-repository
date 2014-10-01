<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Field\Exception;

use InvalidArgumentException;
use Accard\Component\Field\Model\FieldTypes;

/**
 * Invalid field type exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class InvalidFieldTypeException extends InvalidArgumentException
{
	/**
	 * Exception constructor.
	 *
	 * @param string $fieldType
	 */
	public function __construct($fieldType)
	{
		$choices = array_keys(FieldTypes::getChoices());

		$this->message = sprintf(
			'Accard field type must be one of [%s], got "%s".',
			implode(', ', $choices),
			$fieldType
		);
	}
}
