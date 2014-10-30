<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Import;

/**
 * Import events.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class Events
{
    const INITIALIZE = 'accard.import.initialize';
    const PRE_IMPORT = 'accard.import.pre_import';
    const CONVERT = 'accard.import.convert';
    const POST_IMPORT = 'accard.import.post_import';
    const FINISH = 'accard.import.finish';

    /**
     * Import accept event.
     *
     * @var string
     */
    const ACCEPT = 'accard.import.accept';

    /**
     * Import decline event.
     *
     * @var string
     */
    const DECLINE = 'accard.import.decline';
}
