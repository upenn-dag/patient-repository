<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\OutcomesBundle\Exception;

use InvalidArgumentException;

/**
 * Export format not found exception.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ExportFormatNotAllowedException extends InvalidArgumentException implements OutcomesException
{
    /**
     * Exception constructor.
     *
     * @param string $format
     */
    public function __construct($exportFormat)
    {
        $this->message = sprintf('Outcomes export format "%s" not found.', $exportFormat);
    }
}
