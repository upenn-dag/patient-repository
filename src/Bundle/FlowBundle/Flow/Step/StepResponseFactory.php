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

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * Step response factory.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 */
class StepResponseFactory
{
    public function createResponse(ResultInterface $resultObject)
    {
        $result = $resultObject->getResult();

        if ($resultObject instanceof DisplayResult) {
            return new Response($result);
        }
    }
}
