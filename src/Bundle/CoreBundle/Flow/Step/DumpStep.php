<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Flow\Step;

use Accard\Bundle\FlowBundle\Flow\Context\FlowContextInterface;
use Accard\Bundle\FlowBundle\Flow\Step\ControllerStep;

/**
 * A fake step for dumping data.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class DumpStep extends ControllerStep
{
    /**
     * {@inheritdoc}
     */
    public function display(FlowContextInterface $context)
    {
        return $this->render('AccardWebBundle:Frontend\Flow:dump_step.html.twig', array(
            'context' => $context,
        ));
    }
}
