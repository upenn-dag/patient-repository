<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\CoreBundle\Controller;

use DAG\Bundle\ResourceBundle\Controller\ResourceController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Pagerfanta\Pagerfanta;

/**
 * Drug controller.
 *
 * @author Frank Bardon Jr. <bardonf@upenn.edu>
 * @author Dylan Pierce <piercedy@upenn.edu>
 */
class DrugController extends ResourceController
{
    /**
     * {@inheritdoc}
     */
    public function getForm($resource = null)
    {
        if ($this->config->isApiRequest()) {
            return $this
                ->container
                ->get('form.factory')
                ->createNamed('', $this->config->getFormType(), $resource)
            ;
        }

        return $this->createForm($this->config->getFormType(), $resource);
    }
}
