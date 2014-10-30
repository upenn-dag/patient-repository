<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\ResourceBundle\Event;

use Symfony\Component\EventDispatcher\Event;

/**
 * Import accept event.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ImportAcceptEvent extends Event
{
    private $record;
    private $target;
    private $signal;

    public function __construct($record, $target, $signal = null)
    {
        $this->record = $record;
        $this->target = $target;
        $this->signal = $signal;
    }

    public function getRecord()
    {
        return $this->record;
    }

    public function getTarget()
    {
        return $this->target;
    }

    public function getSignal()
    {
        return $this->signal;
    }
}
