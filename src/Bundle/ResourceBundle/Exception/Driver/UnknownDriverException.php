<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */

namespace Accard\Bundle\ResourceBundle\Exception\Driver;

/**
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class UnknownDriverException extends \Exception
{
    public function __construct($driver)
    {
        parent::__construct(sprintf(
            'Unknown driver "%s"',
            $driver
        ));
    }
}
