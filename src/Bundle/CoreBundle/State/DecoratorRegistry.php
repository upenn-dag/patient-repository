<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\State;

/**
 * State decorator registry.
 *
 * This is a stop-gap measure for being able to extend object state definitions
 * in the future. This is simply called programatically, instead of having any
 * significant, dynamic behavior.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DecoratorRegistry
{
    const PREFIX = '\Accard\Bundle\CoreBundle\State\\';

    private $decoratorMap = array(
        'patient' => 'PatientObjectStateDecorator',
        'patient_phase' => 'PhaseObjectStateDecorator',
        //'diagnosis' => 'DiagnosisObjectStateDecorator',
        'activity' => 'ActivityObjectStateDecorator',
        'regimen' => 'RegimenObjectStateDecorator',
    );

    /**
     * Test if a decorator is registered for this object.
     *
     * @param mixed $object
     * @return boolean
     */
    public function hasDecoratorFor($object)
    {
        return isset($this->decoratorMap[$object]);
    }

    /**
     * Get decorator for object.
     *
     * @param mixed $object
     * @return string
     */
    public function getDecoratorFor($object)
    {
        $class = $this->hasDecoratorFor($object) ? $this->decoratorMap[$object] : null;

        if ($class) {
            return self::PREFIX.$class;
        }
    }
}
