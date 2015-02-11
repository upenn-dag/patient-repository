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
 * Activity object state decorator.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class ActivityObjectStateDecorator extends ObjectStateDecorator
{
    /**
     * {@inheritdoc}
     */
    public function preparePrototype(ObjectPrototypeState $prototypeState, $prototype)
    {
        $prototypeState
            ->addExtra('allowDrug', $prototype->getAllowDrug())
            ->addExtra('drugGroup', $prototype->getDrugGroup() ? $prototype->getDrugGroup()->getName() : null)
        ;

        return parent::preparePrototype($prototypeState, $prototype);
    }
}
