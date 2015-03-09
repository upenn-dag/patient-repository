<?php
namespace Accard\Bundle\RIDICBundle\Import;

/**
 * RIDIC \ Import \ Converter
 *
 * @author Dylan Pierce <piercedy@upenn.edu>
 */

use Accard\Bundle\ResourceBundle\Import\ConverterInterface;
use Accard\Bundle\ResourceBundle\Import\Events;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;
use Accard\Component\Core\Model\Sample;
use Accard\Component\Core\Model\Source;
use Accard\Component\Prototype\Provider\PrototypeProviderInterface;
use Accard\Component\Sample\Model\FieldValue;

class Converter implements ConverterInterface
{
    private $prototypeProvider;

    public function __construct(PrototypeProviderInterface $prototypeProvider)
    {
        $this->prototypeProvider = $prototypeProvider;
    }

    /**
     * Converts record array into actual target entity.
     *
     * @param ImportEvent $event
     */
    public function convert(ImportEvent $event)
    {

    }
}