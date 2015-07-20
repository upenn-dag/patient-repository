<?php


/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Component\Option\Test;

use ReflectionClass;
use Doctrine\Common\Collection\ArrayCollection;
use Accard\Component\Option\Model\Option;

/**
 * Option orderable collection generator.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class OptionOrderableCollectionGenerator
{
    /**
     * Generates an option with values.
     *
     * @param string $name
     * @param string $presentation
     * @return OptionInterface
     */
    public static function option($name, $presentation)
    {
        return (new Option())->setName($name)->setPresentation($presentation);
    }

    public static function value($id, $value, $order = 0, $lock = false)
    {
        $reflector = new ReflectionClass('Accard\\Component\\Option\\Model\\OptionValue');
        $idProp = $reflector->getProperty('id');
        $idProp->setAccessible(true);

        $optValue = $reflector->newInstance();
        $idProp->setValue($optValue, $id);

        return $optValue
            ->setValue($value)
            ->setOrder($order)
            ->setLocked($lock);
    }
}
