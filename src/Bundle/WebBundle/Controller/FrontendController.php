<?php

/**
 * This file is part of the Accard package.
 *
 * (c) University of Pennsylvania
 *
 * For the full copyright and license information, please view the
 * LICENSE file that was distributed with this source code.
 */
namespace Accard\Bundle\WebBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Accard\Bundle\ResourceBundle\Import\ResourceInterface;
use Accard\Bundle\ResourceBundle\Import\StaticImporter;
use Accard\Bundle\ResourceBundle\Event\ImportEvent;

class FrontendController extends Controller
{
    /**
     * Frontend homepage action.
     *
     * @var Response
     */
    public function mainAction()
    {
        return $this->render('AccardWebBundle:Frontend:main.html.twig');
    }
}
