<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\FlowBundle\Flow\Step;

use Accard\Bundle\FlowBundle\Flow\Context\FlowContextInterface;

/**
 * Sample step.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class SampleStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function display(FlowContextInterface $context)
    {
        return $this->render('AccardWebBundle:Frontend\Flow:sample.html.twig', array(
            'context' => $context,
        ));
    }
}
