<?php

namespace Accard\Bundle\PDSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('AccardPDSBundle:Default:index.html.twig', array('name' => $name));
    }
}
