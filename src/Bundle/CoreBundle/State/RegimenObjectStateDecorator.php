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
 * Regimen object state decorator.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class RegimenObjectStateDecorator extends ObjectStateDecorator
{
    /**
     * {@inheritdoc}
     */
    public function preparePrototype(ObjectPrototypeState $prototypeState, $prototype)
    {
        $activityPrototypes = array();
        foreach ($prototype->getActivityPrototypes() as $activityPrototype) {
            $activityPrototypes[] = $activityPrototype->getName();
        }

        $prototypeState
            ->addExtra('allowDrug', $prototype->getAllowDrug())
            ->addExtra('drugGroup', $prototype->getDrugGroup() ? $prototype->getDrugGroup()->getName() : null)
            ->addExtra('activityPrototypes', $activityPrototypes)
        ;

        return parent::preparePrototype($prototypeState, $prototype);
    }
}
