<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Core\Exception;

use Exception;

/**
 * Redundant persistance exception.
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class RedundantPersistanceException extends Exception
{
	/**
	 * Exception constructor.
	 *
	 * @param string $object
	 */
	public function __construct($name, $object)
	{
		$this->message = sprintf(
			'Object name "%s" of type %s already persisted',
			$name,
			$object
		);
	}
}
